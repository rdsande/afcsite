import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:convert';

import '../models/fan.dart';
import '../services/api_service.dart';

class AuthProvider extends StateNotifier<AuthState> {
  final ApiService _apiService = ApiService();
  
  AuthProvider() : super(AuthState.initial());

  Future<void> checkAuthStatus() async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('auth_token');
    
    if (token != null) {
      try {
        // Validate token by fetching user profile
        final fan = await _apiService.getFanProfile(token);
        if (fan != null) {
          state = AuthState.authenticated(fan: fan);
        } else {
          // Token is invalid, clear it
          await prefs.remove('auth_token');
          await prefs.setBool('isLoggedIn', false);
          state = AuthState.unauthenticated();
        }
      } catch (e) {
        // Error validating token, clear it
        await prefs.remove('auth_token');
        await prefs.setBool('isLoggedIn', false);
        state = AuthState.unauthenticated();
      }
    } else {
      state = AuthState.unauthenticated();
    }
  }

  Future<void> register({
    required String firstName,
    required String lastName,
    String? email,
    required DateTime dateOfBirth,
    required String phone,
    required String gender,
    required String password,
    required String region,
    required String district,
  }) async {
    try {
      state = AuthState.loading();
      
      // Call API to register fan
      final result = await _apiService.fanRegister(
        firstName: firstName,
        lastName: lastName,
        email: email,
        phone: phone,
        password: password,
        gender: gender,
        dateOfBirth: dateOfBirth,
        region: region,
        district: district,
      );
      
      if (result != null) {
        // Registration successful
        final token = result['token'] as String?;
        final fanData = result['fan'] as Map<String, dynamic>?;
        
        if (token != null && fanData != null) {
          final fan = Fan.fromJson(fanData);
          
          // Save to local storage
          final prefs = await SharedPreferences.getInstance();
          await prefs.setString('auth_token', token);
          await prefs.setBool('isLoggedIn', true);
          
          state = AuthState.authenticated(fan: fan);
        } else {
          state = AuthState.error('Registration failed: Invalid response');
        }
      } else {
        state = AuthState.error('Registration failed: Please check your details and try again');
      }
    } catch (e) {
      state = AuthState.error('Registration failed: ${e.toString()}');
    }
  }

  Future<void> login({
    required String phone,
    required String password,
  }) async {
    try {
      state = AuthState.loading();
      
      // Call API to login fan
      final result = await _apiService.fanLogin(phone, password);
      
      if (result != null) {
        // Login successful
        final token = result['token'] as String?;
        final fanData = result['fan'] as Map<String, dynamic>?;
        
        if (token != null && fanData != null) {
          final fan = Fan.fromJson(fanData);
          
          // Save to local storage
          final prefs = await SharedPreferences.getInstance();
          await prefs.setString('auth_token', token);
          await prefs.setBool('isLoggedIn', true);
          
          state = AuthState.authenticated(fan: fan);
        } else {
          state = AuthState.error('Login failed: Invalid response');
        }
      } else {
        state = AuthState.error('Login failed: Invalid phone number or password');
      }
    } catch (e) {
      state = AuthState.error('Login failed: ${e.toString()}');
    }
  }

  Future<void> logout() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final token = prefs.getString('auth_token');
      
      // Call API to logout if token exists
      if (token != null) {
        await _apiService.fanLogout(token);
      }
      
      // Clear local storage
      await prefs.remove('auth_token');
      await prefs.setBool('isLoggedIn', false);
      
      state = AuthState.unauthenticated();
    } catch (e) {
      // Even if API call fails, clear local storage
      final prefs = await SharedPreferences.getInstance();
      await prefs.remove('auth_token');
      await prefs.setBool('isLoggedIn', false);
      
      state = AuthState.unauthenticated();
    }
  }
}

class AuthState {
  final bool isLoading;
  final bool isAuthenticated;
  final Fan? fan;
  final String? error;

  const AuthState({
    required this.isLoading,
    required this.isAuthenticated,
    this.fan,
    this.error,
  });

  factory AuthState.initial() => const AuthState(
    isLoading: false,
    isAuthenticated: false,
  );

  factory AuthState.loading() => const AuthState(
    isLoading: true,
    isAuthenticated: false,
  );

  factory AuthState.authenticated({Fan? fan}) => AuthState(
    isLoading: false,
    isAuthenticated: true,
    fan: fan,
  );

  factory AuthState.unauthenticated() => const AuthState(
    isLoading: false,
    isAuthenticated: false,
  );

  factory AuthState.error(String error) => AuthState(
    isLoading: false,
    isAuthenticated: false,
    error: error,
  );
}

final authProviderProvider = StateNotifierProvider<AuthProvider, AuthState>((ref) {
  return AuthProvider();
});
