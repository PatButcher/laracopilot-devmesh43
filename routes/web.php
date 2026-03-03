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

// Public routes
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/discover', [TrackController::class, 'discover'])->name('discover');
Route::get('/tracks', [TrackController::class, 'index'])->name('tracks.index');
Route::get('/tracks/{slug}', [TrackController::class, 'show'])->name('tracks.show');
Route::post('/tracks/{id}/play', [TrackController::class, 'incrementPlay'])->name('tracks.play');
Route::get('/artists', [ArtistController::class, 'index'])->name('artists.index');
Route::get('/artists/{slug}', [ArtistController::class, 'show'])->name('artists.show');
Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');
Route::get('/albums/{slug}', [AlbumController::class, 'show'])->name('albums.show');
Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');
Route::get('/genres/{slug}', [GenreController::class, 'show'])->name('genres.show');
Route::get('/channels', [ChannelController::class, 'index'])->name('channels.index');
Route::get('/channels/{slug}', [ChannelController::class, 'show'])->name('channels.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated user routes
Route::get('/upload', [TrackController::class, 'create'])->name('tracks.create');
Route::post('/upload', [TrackController::class, 'store'])->name('tracks.store');
Route::get('/tracks/{id}/edit', [TrackController::class, 'edit'])->name('tracks.edit');
Route::put('/tracks/{id}', [TrackController::class, 'update'])->name('tracks.update');
Route::delete('/tracks/{id}', [TrackController::class, 'destroy'])->name('tracks.destroy');
Route::get('/my-tracks', [TrackController::class, 'myTracks'])->name('tracks.mine');

Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlists.index');
Route::get('/playlists/create', [PlaylistController::class, 'create'])->name('playlists.create');
Route::post('/playlists', [PlaylistController::class, 'store'])->name('playlists.store');
Route::get('/playlists/{id}', [PlaylistController::class, 'show'])->name('playlists.show');
Route::get('/playlists/{id}/edit', [PlaylistController::class, 'edit'])->name('playlists.edit');
Route::put('/playlists/{id}', [PlaylistController::class, 'update'])->name('playlists.update');
Route::delete('/playlists/{id}', [PlaylistController::class, 'destroy'])->name('playlists.destroy');
Route::post('/playlists/{id}/tracks', [PlaylistController::class, 'addTrack'])->name('playlists.tracks.add');
Route::delete('/playlists/{id}/tracks/{trackId}', [PlaylistController::class, 'removeTrack'])->name('playlists.tracks.remove');

Route::post('/favourites/{trackId}', [FavouriteController::class, 'toggle'])->name('favourites.toggle');
Route::get('/favourites', [FavouriteController::class, 'index'])->name('favourites.index');

Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

// Admin auth routes
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin dashboard
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

// Admin tracks
Route::get('/admin/tracks', [TrackAdminController::class, 'index'])->name('admin.tracks.index');
Route::get('/admin/tracks/create', [TrackAdminController::class, 'create'])->name('admin.tracks.create');
Route::post('/admin/tracks', [TrackAdminController::class, 'store'])->name('admin.tracks.store');
Route::get('/admin/tracks/{id}/edit', [TrackAdminController::class, 'edit'])->name('admin.tracks.edit');
Route::put('/admin/tracks/{id}', [TrackAdminController::class, 'update'])->name('admin.tracks.update');
Route::delete('/admin/tracks/{id}', [TrackAdminController::class, 'destroy'])->name('admin.tracks.destroy');

// Admin artists
Route::get('/admin/artists', [ArtistAdminController::class, 'index'])->name('admin.artists.index');
Route::get('/admin/artists/create', [ArtistAdminController::class, 'create'])->name('admin.artists.create');
Route::post('/admin/artists', [ArtistAdminController::class, 'store'])->name('admin.artists.store');
Route::get('/admin/artists/{id}/edit', [ArtistAdminController::class, 'edit'])->name('admin.artists.edit');
Route::put('/admin/artists/{id}', [ArtistAdminController::class, 'update'])->name('admin.artists.update');
Route::delete('/admin/artists/{id}', [ArtistAdminController::class, 'destroy'])->name('admin.artists.destroy');

// Admin albums
Route::get('/admin/albums', [AlbumAdminController::class, 'index'])->name('admin.albums.index');
Route::get('/admin/albums/create', [AlbumAdminController::class, 'create'])->name('admin.albums.create');
Route::post('/admin/albums', [AlbumAdminController::class, 'store'])->name('admin.albums.store');
Route::get('/admin/albums/{id}/edit', [AlbumAdminController::class, 'edit'])->name('admin.albums.edit');
Route::put('/admin/albums/{id}', [AlbumAdminController::class, 'update'])->name('admin.albums.update');
Route::delete('/admin/albums/{id}', [AlbumAdminController::class, 'destroy'])->name('admin.albums.destroy');

// Admin genres
Route::get('/admin/genres', [GenreAdminController::class, 'index'])->name('admin.genres.index');
Route::get('/admin/genres/create', [GenreAdminController::class, 'create'])->name('admin.genres.create');
Route::post('/admin/genres', [GenreAdminController::class, 'store'])->name('admin.genres.store');
Route::get('/admin/genres/{id}/edit', [GenreAdminController::class, 'edit'])->name('admin.genres.edit');
Route::put('/admin/genres/{id}', [GenreAdminController::class, 'update'])->name('admin.genres.update');
Route::delete('/admin/genres/{id}', [GenreAdminController::class, 'destroy'])->name('admin.genres.destroy');

// Admin playlists
Route::get('/admin/playlists', [PlaylistAdminController::class, 'index'])->name('admin.playlists.index');
Route::delete('/admin/playlists/{id}', [PlaylistAdminController::class, 'destroy'])->name('admin.playlists.destroy');

// Admin channels
Route::get('/admin/channels', [ChannelAdminController::class, 'index'])->name('admin.channels.index');
Route::get('/admin/channels/create', [ChannelAdminController::class, 'create'])->name('admin.channels.create');
Route::post('/admin/channels', [ChannelAdminController::class, 'store'])->name('admin.channels.store');
Route::get('/admin/channels/{id}/edit', [ChannelAdminController::class, 'edit'])->name('admin.channels.edit');
Route::put('/admin/channels/{id}', [ChannelAdminController::class, 'update'])->name('admin.channels.update');
Route::delete('/admin/channels/{id}', [ChannelAdminController::class, 'destroy'])->name('admin.channels.destroy');

// Admin theme
Route::get('/admin/theme', [ThemeAdminController::class, 'index'])->name('admin.theme.index');
Route::put('/admin/theme', [ThemeAdminController::class, 'update'])->name('admin.theme.update');

// Admin menu
Route::get('/admin/menu', [MenuAdminController::class, 'index'])->name('admin.menu.index');
Route::post('/admin/menu', [MenuAdminController::class, 'store'])->name('admin.menu.store');
Route::put('/admin/menu/{id}', [MenuAdminController::class, 'update'])->name('admin.menu.update');
Route::delete('/admin/menu/{id}', [MenuAdminController::class, 'destroy'])->name('admin.menu.destroy');

// Admin metadata
Route::get('/admin/metadata', [MetadataAdminController::class, 'index'])->name('admin.metadata.index');
Route::put('/admin/metadata', [MetadataAdminController::class, 'update'])->name('admin.metadata.update');

// Admin landing page
Route::get('/admin/landing-page', [LandingPageAdminController::class, 'index'])->name('admin.landing.index');
Route::put('/admin/landing-page', [LandingPageAdminController::class, 'update'])->name('admin.landing.update');

// Admin users
Route::get('/admin/users', [UserAdminController::class, 'index'])->name('admin.users.index');
Route::delete('/admin/users/{id}', [UserAdminController::class, 'destroy'])->name('admin.users.destroy');