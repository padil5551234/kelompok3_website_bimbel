<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class AuthHelper
{
    /**
     * Get safe user photo URL with fallback
     */
    public static function getUserPhotoUrl($default = 'img/default-avatar.png')
    {
        try {
            if (Auth::check() && Auth::user()->profile_photo_url) {
                return Auth::user()->profile_photo_url;
            }
        } catch (\Exception $e) {
            // Log error if needed
            \Log::warning('Error getting user photo URL: ' . $e->getMessage());
        }
        
        return asset($default);
    }
    
    /**
     * Get safe user name with fallback
     */
    public static function getUserName($default = 'User')
    {
        try {
            if (Auth::check() && Auth::user()->name) {
                return Auth::user()->name;
            }
        } catch (\Exception $e) {
            \Log::warning('Error getting user name: ' . $e->getMessage());
        }
        
        return $default;
    }
    
    /**
     * Get safe user role with fallback
     */
    public static function getUserRole($default = 'User')
    {
        try {
            if (Auth::check() && Auth::user()->roles()->count() > 0) {
                return Auth::user()->roles()->first()->name;
            }
        } catch (\Exception $e) {
            \Log::warning('Error getting user role: ' . $e->getMessage());
        }
        
        return $default;
    }
    
    /**
     * Check if user is authenticated safely
     */
    public static function isAuthenticated()
    {
        try {
            return Auth::check();
        } catch (\Exception $e) {
            \Log::warning('Error checking authentication: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get authenticated user safely
     */
    public static function getUser()
    {
        try {
            return Auth::user();
        } catch (\Exception $e) {
            \Log::warning('Error getting authenticated user: ' . $e->getMessage());
            return null;
        }
    }
}