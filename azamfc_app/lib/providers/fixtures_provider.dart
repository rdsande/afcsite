import 'package:flutter_riverpod/flutter_riverpod.dart';
import '../models/fixture.dart';
import '../services/api_service.dart';
import 'news_provider.dart';

// Fixtures state class
class FixturesState {
  final List<Fixture> upcomingFixtures;
  final List<Fixture> recentResults;
  final List<Fixture> allFixtures;
  final bool isLoading;
  final String? error;

  const FixturesState({
    this.upcomingFixtures = const [],
    this.recentResults = const [],
    this.allFixtures = const [],
    this.isLoading = false,
    this.error,
  });

  FixturesState copyWith({
    List<Fixture>? upcomingFixtures,
    List<Fixture>? recentResults,
    List<Fixture>? allFixtures,
    bool? isLoading,
    String? error,
  }) {
    return FixturesState(
      upcomingFixtures: upcomingFixtures ?? this.upcomingFixtures,
      recentResults: recentResults ?? this.recentResults,
      allFixtures: allFixtures ?? this.allFixtures,
      isLoading: isLoading ?? this.isLoading,
      error: error ?? this.error,
    );
  }
}

// Fixtures provider
class FixturesNotifier extends StateNotifier<FixturesState> {
  final ApiService _apiService;

  FixturesNotifier(this._apiService) : super(const FixturesState());

  // Fetch upcoming fixtures
  Future<void> fetchUpcomingFixtures() async {
    state = state.copyWith(isLoading: true, error: null);
    
    try {
      final upcomingFixtures = await _apiService.getUpcomingFixtures();
      state = state.copyWith(
        upcomingFixtures: upcomingFixtures,
        isLoading: false,
      );
    } catch (e) {
      state = state.copyWith(
        isLoading: false,
        error: 'Failed to load upcoming fixtures: $e',
      );
    }
  }

  // Fetch recent results
  Future<void> fetchRecentResults() async {
    state = state.copyWith(isLoading: true, error: null);
    
    try {
      final recentResults = await _apiService.getRecentResults();
      state = state.copyWith(
        recentResults: recentResults,
        isLoading: false,
      );
    } catch (e) {
      state = state.copyWith(
        isLoading: false,
        error: 'Failed to load recent results: $e',
      );
    }
  }

  // Fetch all fixtures
  Future<void> fetchAllFixtures({int page = 1}) async {
    if (page == 1) {
      state = state.copyWith(isLoading: true, error: null);
    }
    
    try {
      final allFixtures = await _apiService.getAllFixtures(page: page);
      
      if (page == 1) {
        state = state.copyWith(
          allFixtures: allFixtures,
          isLoading: false,
        );
      } else {
        // Append to existing fixtures for pagination
        state = state.copyWith(
          allFixtures: [...state.allFixtures, ...allFixtures],
          isLoading: false,
        );
      }
    } catch (e) {
      state = state.copyWith(
        isLoading: false,
        error: 'Failed to load fixtures: $e',
      );
    }
  }

  // Fetch both upcoming fixtures and recent results
  Future<void> fetchHomeFixtures() async {
    await Future.wait([
      fetchUpcomingFixtures(),
      fetchRecentResults(),
    ]);
  }

  // Get fixture detail
  Future<Fixture?> getFixtureDetail(int fixtureId) async {
    try {
      return await _apiService.getFixtureDetail(fixtureId);
    } catch (e) {
      state = state.copyWith(error: 'Failed to load fixture detail: $e');
      return null;
    }
  }

  // Clear error
  void clearError() {
    state = state.copyWith(error: null);
  }
}

// Provider instances
final fixturesProvider = StateNotifierProvider<FixturesNotifier, FixturesState>((ref) {
  final apiService = ref.watch(apiServiceProvider);
  return FixturesNotifier(apiService);
});

// Convenience providers
final upcomingFixturesProvider = Provider<List<Fixture>>((ref) {
  return ref.watch(fixturesProvider).upcomingFixtures;
});

final recentResultsProvider = Provider<List<Fixture>>((ref) {
  return ref.watch(fixturesProvider).recentResults;
});

final allFixturesProvider = Provider<List<Fixture>>((ref) {
  return ref.watch(fixturesProvider).allFixtures;
});

final fixturesLoadingProvider = Provider<bool>((ref) {
  return ref.watch(fixturesProvider).isLoading;
});

final fixturesErrorProvider = Provider<String?>((ref) {
  return ref.watch(fixturesProvider).error;
});