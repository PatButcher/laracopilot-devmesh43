<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\TrackAdminController;
use App\Http\Controllers\Admin\ArtistAdminController;
use App\Http\Controllers\Admin\AlbumAdminController;
use App\Http\Controllers\Admin\GenreAdminController;
use App\Http\Controllers\Admin\PlaylistAdminController;
use App\Http\Controllers\Admin\ChannelAdminController;
use App\Http\Controllers\Admin\ThemeAdminController;
use App\Http\Controllers\Admin\MenuAdminController;
use App\Http\Controllers\Admin\MetadataAdminController;
use App\Http\Controllers\Admin\LandingPageAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;

// ── Public routes ─────────────────────────────────────────────────────────
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/discover', [TrackController::class, 'discover'])->name('discover');
Route::get('/tracks', [TrackController::class, 'index'])->name('tracks.index');
Route::get('/tracks/{slug}', [TrackController::class, 'show'])->name('tracks.show')->middleware('validate.slug');
Route::post('/tracks/{id}/play', [TrackController::class, 'incrementPlay'])->name('tracks.play')->middleware('rate.limit:api');
Route::get('/artists', [ArtistController::class, 'index'])->name('artists.index');
Route::get('/artists/{slug}', [ArtistController::class, 'show'])->name('artists.show')->middleware('validate.slug');
Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');
Route::get('/albums/{slug}', [AlbumController::class, 'show'])->name('albums.show')->middleware('validate.slug');
Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');
Route::get('/genres/{slug}', [GenreController::class, 'show'])->name('genres.show')->middleware('validate.slug');
Route::get('/channels', [ChannelController::class, 'index'])->name('channels.index');
Route::get('/channels/{slug}', [ChannelController::class, 'show'])->name('channels.show')->middleware('validate.slug');
Route::get('/search', [SearchController::class, 'index'])->name('search')->middleware('rate.limit:api');

// ── Authentication routes ─────────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware(['rate.limit:auth', 'brute.force', 'honeypot']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware(['rate.limit:auth', 'honeypot']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Authenticated user routes ─────────────────────────────────────────────
Route::get('/upload', [TrackController::class, 'create'])->name('tracks.create');
Route::post('/upload', [TrackController::class, 'store'])->name('tracks.store')->middleware(['rate.limit:upload', 'file.upload']);
Route::get('/tracks/{id}/edit', [TrackController::class, 'edit'])->name('tracks.edit');
Route::put('/tracks/{id}', [TrackController::class, 'update'])->name('tracks.update')->middleware('file.upload');
Route::delete('/tracks/{id}', [TrackController::class, 'destroy'])->name('tracks.destroy');
Route::get('/my-tracks', [TrackController::class, 'myTracks'])->name('tracks.mine');

Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlists.index');
Route::get('/playlists/create', [PlaylistController::class, 'create'])->name('playlists.create');
Route::post('/playlists', [PlaylistController::class, 'store'])->name('playlists.store')->middleware('rate.limit:api');
Route::get('/playlists/{id}', [PlaylistController::class, 'show'])->name('playlists.show');
Route::get('/playlists/{id}/edit', [PlaylistController::class, 'edit'])->name('playlists.edit');
Route::put('/playlists/{id}', [PlaylistController::class, 'update'])->name('playlists.update');
Route::delete('/playlists/{id}', [PlaylistController::class, 'destroy'])->name('playlists.destroy');
Route::post('/playlists/{id}/tracks', [PlaylistController::class, 'addTrack'])->name('playlists.tracks.add');
Route::delete('/playlists/{id}/tracks/{trackId}', [PlaylistController::class, 'removeTrack'])->name('playlists.tracks.remove');

Route::post('/favourites/{trackId}', [FavouriteController::class, 'toggle'])->name('favourites.toggle')->middleware('rate.limit:api');
Route::get('/favourites', [FavouriteController::class, 'index'])->name('favourites.index');

Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

// ── Admin authentication ──────────────────────────────────────────────────
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login')->middleware('admin.ip');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->middleware(['admin.ip', 'rate.limit:auth', 'brute.force', 'honeypot']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ── Admin panel (protected) ───────────────────────────────────────────────
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware(['admin.ip', 'admin.auth']);

// Admin tracks
Route::get('/admin/tracks', [TrackAdminController::class, 'index'])->name('admin.tracks.index')->middleware(['admin.ip', 'admin.auth']);
Route::get('/admin/tracks/create', [TrackAdminController::class, 'create'])->name('admin.tracks.create')->middleware(['admin.ip', 'admin.auth']);
Route::post('/admin/tracks', [TrackAdminController::class, 'store'])->name('admin.tracks.store')->middleware(['admin.ip', 'admin.auth', 'file.upload']);
Route::get('/admin/tracks/{id}/edit', [TrackAdminController::class, 'edit'])->name('admin.tracks.edit')->middleware(['admin.ip', 'admin.auth']);
Route::put('/admin/tracks/{id}', [TrackAdminController::class, 'update'])->name('admin.tracks.update')->middleware(['admin.ip', 'admin.auth', 'file.upload']);
Route::delete('/admin/tracks/{id}', [TrackAdminController::class, 'destroy'])->name('admin.tracks.destroy')->middleware(['admin.ip', 'admin.auth']);

// Admin artists
Route::get('/admin/artists', [ArtistAdminController::class, 'index'])->name('admin.artists.index')->middleware(['admin.ip', 'admin.auth']);
Route::get('/admin/artists/create', [ArtistAdminController::class, 'create'])->name('admin.artists.create')->middleware(['admin.ip', 'admin.auth']);
Route::post('/admin/artists', [ArtistAdminController::class, 'store'])->name('admin.artists.store')->middleware(['admin.ip', 'admin.auth', 'file.upload']);
Route::get('/admin/artists/{id}/edit', [ArtistAdminController::class, 'edit'])->name('admin.artists.edit')->middleware(['admin.ip', 'admin.auth']);
Route::put('/admin/artists/{id}', [ArtistAdminController::class, 'update'])->name('admin.artists.update')->middleware(['admin.ip', 'admin.auth', 'file.upload']);
Route::delete('/admin/artists/{id}', [ArtistAdminController::class, 'destroy'])->name('admin.artists.destroy')->middleware(['admin.ip', 'admin.auth']);

// Admin albums
Route::get('/admin/albums', [AlbumAdminController::class, 'index'])->name('admin.albums.index')->middleware(['admin.ip', 'admin.auth']);
Route::get('/admin/albums/create', [AlbumAdminController::class, 'create'])->name('admin.albums.create')->middleware(['admin.ip', 'admin.auth']);
Route::post('/admin/albums', [AlbumAdminController::class, 'store'])->name('admin.albums.store')->middleware(['admin.ip', 'admin.auth', 'file.upload']);
Route::get('/admin/albums/{id}/edit', [AlbumAdminController::class, 'edit'])->name('admin.albums.edit')->middleware(['admin.ip', 'admin.auth']);
Route::put('/admin/albums/{id}', [AlbumAdminController::class, 'update'])->name('admin.albums.update')->middleware(['admin.ip', 'admin.auth', 'file.upload']);
Route::delete('/admin/albums/{id}', [AlbumAdminController::class, 'destroy'])->name('admin.albums.destroy')->middleware(['admin.ip', 'admin.auth']);

// Admin genres
Route::get('/admin/genres', [GenreAdminController::class, 'index'])->name('admin.genres.index')->middleware(['admin.ip', 'admin.auth']);
Route::get('/admin/genres/create', [GenreAdminController::class, 'create'])->name('admin.genres.create')->middleware(['admin.ip', 'admin.auth']);
Route::post('/admin/genres', [GenreAdminController::class, 'store'])->name('admin.genres.store')->middleware(['admin.ip', 'admin.auth']);
Route::get('/admin/genres/{id}/edit', [GenreAdminController::class, 'edit'])->name('admin.genres.edit')->middleware(['admin.ip', 'admin.auth']);
Route::put('/admin/genres/{id}', [GenreAdminController::class, 'update'])->name('admin.genres.update')->middleware(['admin.ip', 'admin.auth']);
Route::delete('/admin/genres/{id}', [GenreAdminController::class, 'destroy'])->name('admin.genres.destroy')->middleware(['admin.ip', 'admin.auth']);

// Admin playlists
Route::get('/admin/playlists', [PlaylistAdminController::class, 'index'])->name('admin.playlists.index')->middleware(['admin.ip', 'admin.auth']);
Route::delete('/admin/playlists/{id}', [PlaylistAdminController::class, 'destroy'])->name('admin.playlists.destroy')->middleware(['admin.ip', 'admin.auth']);

// Admin channels
Route::get('/admin/channels', [ChannelAdminController::class, 'index'])->name('admin.channels.index')->middleware(['admin.ip', 'admin.auth']);
Route::get('/admin/channels/create', [ChannelAdminController::class, 'create'])->name('admin.channels.create')->middleware(['admin.ip', 'admin.auth']);
Route::post('/admin/channels', [ChannelAdminController::class, 'store'])->name('admin.channels.store')->middleware(['admin.ip', 'admin.auth']);
Route::get('/admin/channels/{id}/edit', [ChannelAdminController::class, 'edit'])->name('admin.channels.edit')->middleware(['admin.ip', 'admin.auth']);
Route::put('/admin/channels/{id}', [ChannelAdminController::class, 'update'])->name('admin.channels.update')->middleware(['admin.ip', 'admin.auth']);
Route::delete('/admin/channels/{id}', [ChannelAdminController::class, 'destroy'])->name('admin.channels.destroy')->middleware(['admin.ip', 'admin.auth']);

// Admin theme / menu / metadata / landing / users
Route::get('/admin/theme', [ThemeAdminController::class, 'index'])->name('admin.theme.index')->middleware(['admin.ip', 'admin.auth']);
Route::put('/admin/theme', [ThemeAdminController::class, 'update'])->name('admin.theme.update')->middleware(['admin.ip', 'admin.auth']);
Route::get('/admin/menu', [MenuAdminController::class, 'index'])->name('admin.menu.index')->middleware(['admin.ip', 'admin.auth']);
Route::post('/admin/menu', [MenuAdminController::class, 'store'])->name('admin.menu.store')->middleware(['admin.ip', 'admin.auth']);
Route::put('/admin/menu/{id}', [MenuAdminController::class, 'update'])->name('admin.menu.update')->middleware(['admin.ip', 'admin.auth']);
Route::delete('/admin/menu/{id}', [MenuAdminController::class, 'destroy'])->name('admin.menu.destroy')->middleware(['admin.ip', 'admin.auth']);
Route::get('/admin/metadata', [MetadataAdminController::class, 'index'])->name('admin.metadata.index')->middleware(['admin.ip', 'admin.auth']);
Route::put('/admin/metadata', [MetadataAdminController::class, 'update'])->name('admin.metadata.update')->middleware(['admin.ip', 'admin.auth']);
Route::get('/admin/landing-page', [LandingPageAdminController::class, 'index'])->name('admin.landing.index')->middleware(['admin.ip', 'admin.auth']);
Route::put('/admin/landing-page', [LandingPageAdminController::class, 'update'])->name('admin.landing.update')->middleware(['admin.ip', 'admin.auth']);
Route::get('/admin/users', [UserAdminController::class, 'index'])->name('admin.users.index')->middleware(['admin.ip', 'admin.auth']);
Route::delete('/admin/users/{id}', [UserAdminController::class, 'destroy'])->name('admin.users.destroy')->middleware(['admin.ip', 'admin.auth']);