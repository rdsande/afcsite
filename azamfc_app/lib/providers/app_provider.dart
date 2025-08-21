import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';

class AppProvider extends StateNotifier<AppState> {
  AppProvider() : super(AppState.initial());

  void setLoading(bool loading) {
    state = state.copyWith(isLoading: loading);
  }

  void setError(String? error) {
    state = state.copyWith(error: error);
  }

  void clearError() {
    state = state.copyWith(error: null);
  }
}

class AppState {
  final bool isLoading;
  final String? error;

  const AppState({
    required this.isLoading,
    this.error,
  });

  factory AppState.initial() => const AppState(isLoading: false);

  AppState copyWith({
    bool? isLoading,
    String? error,
  }) {
    return AppState(
      isLoading: isLoading ?? this.isLoading,
      error: error ?? this.error,
    );
  }
}

final appProviderProvider = StateNotifierProvider<AppProvider, AppState>((ref) {
  return AppProvider();
});
