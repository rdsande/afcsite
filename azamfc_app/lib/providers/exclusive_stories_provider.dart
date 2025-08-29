import 'package:flutter_riverpod/flutter_riverpod.dart';
import '../models/exclusive_story.dart';
import '../services/api_service.dart';

// State class for exclusive stories
class ExclusiveStoriesState {
  final List<ExclusiveStory> featuredStories;
  final List<ExclusiveStory> allStories;
  final bool isLoading;
  final String? error;
  final bool hasMore;
  final int currentPage;

  const ExclusiveStoriesState({
    this.featuredStories = const [],
    this.allStories = const [],
    this.isLoading = false,
    this.error,
    this.hasMore = true,
    this.currentPage = 1,
  });

  ExclusiveStoriesState copyWith({
    List<ExclusiveStory>? featuredStories,
    List<ExclusiveStory>? allStories,
    bool? isLoading,
    String? error,
    bool? hasMore,
    int? currentPage,
  }) {
    return ExclusiveStoriesState(
      featuredStories: featuredStories ?? this.featuredStories,
      allStories: allStories ?? this.allStories,
      isLoading: isLoading ?? this.isLoading,
      error: error ?? this.error,
      hasMore: hasMore ?? this.hasMore,
      currentPage: currentPage ?? this.currentPage,
    );
  }
}

// Notifier class for exclusive stories
class ExclusiveStoriesNotifier extends StateNotifier<ExclusiveStoriesState> {
  final ApiService _apiService;
  final Ref _ref;

  ExclusiveStoriesNotifier(this._apiService, this._ref)
      : super(const ExclusiveStoriesState());

  // Fetch featured exclusive stories for home screen
  Future<void> fetchFeaturedStories() async {
    state = state.copyWith(isLoading: true, error: null);

    try {
      final stories = await _apiService.getFeaturedExclusiveStories(
        limit: 4,
      );
      
      state = state.copyWith(
        featuredStories: stories,
        isLoading: false,
        error: null,
      );
    } catch (e) {
      state = state.copyWith(
        isLoading: false,
        error: e.toString(),
      );
    }
  }

  // Fetch all exclusive stories with pagination
  Future<void> fetchAllStories({bool refresh = false}) async {
    if (refresh) {
      state = state.copyWith(
        currentPage: 1,
        hasMore: true,
        allStories: [],
      );
    }

    if (!state.hasMore && !refresh) return;

    state = state.copyWith(isLoading: true, error: null);

    try {
      final response = await _apiService.getExclusiveStories(
        page: state.currentPage,
        perPage: 10,
      );
      
      if (response.success) {
        final newStories = refresh 
            ? response.stories 
            : [...state.allStories, ...response.stories];
        
        state = state.copyWith(
          allStories: newStories,
          isLoading: false,
          error: null,
          currentPage: state.currentPage + 1,
          hasMore: response.stories.length >= 10,
        );
      } else {
        state = state.copyWith(
          isLoading: false,
          error: response.error ?? 'Failed to fetch exclusive stories',
        );
      }
    } catch (e) {
      state = state.copyWith(
        isLoading: false,
        error: e.toString(),
      );
    }
  }

  // Fetch stories by type (photos or videos)
  Future<void> fetchStoriesByType(String type, {bool refresh = false}) async {
    if (refresh) {
      state = state.copyWith(
        currentPage: 1,
        hasMore: true,
        allStories: [],
      );
    }

    if (!state.hasMore && !refresh) return;

    state = state.copyWith(isLoading: true, error: null);

    try {
      final response = await _apiService.getExclusiveStoriesByType(
        type,
        page: state.currentPage,
        perPage: 10,
      );
      
      if (response.success) {
        final newStories = refresh 
            ? response.stories 
            : [...state.allStories, ...response.stories];
        
        state = state.copyWith(
          allStories: newStories,
          isLoading: false,
          error: null,
          currentPage: state.currentPage + 1,
          hasMore: response.stories.length >= 10,
        );
      } else {
        state = state.copyWith(
          isLoading: false,
          error: response.error ?? 'Failed to fetch exclusive stories',
        );
      }
    } catch (e) {
      state = state.copyWith(
        isLoading: false,
        error: e.toString(),
      );
    }
  }

  // Get story detail
  Future<ExclusiveStory?> getStoryDetail(int storyId) async {
    try {
      return await _apiService.getExclusiveStoryDetail(
        storyId,
      );
    } catch (e) {
      return null;
    }
  }

  // Clear error
  void clearError() {
    state = state.copyWith(error: null);
  }
}

// Provider instances
final apiServiceProvider = Provider<ApiService>((ref) => ApiService());

// Provider for exclusive stories
final exclusiveStoriesProvider = StateNotifierProvider<ExclusiveStoriesNotifier, ExclusiveStoriesState>((ref) {
  final apiService = ref.watch(apiServiceProvider);
  return ExclusiveStoriesNotifier(apiService, ref);
});

// Convenience providers for specific data
final featuredExclusiveStoriesProvider = Provider<List<ExclusiveStory>>((ref) {
  return ref.watch(exclusiveStoriesProvider).featuredStories;
});

final allExclusiveStoriesProvider = Provider<List<ExclusiveStory>>((ref) {
  return ref.watch(exclusiveStoriesProvider).allStories;
});

final exclusiveStoriesLoadingProvider = Provider<bool>((ref) {
  return ref.watch(exclusiveStoriesProvider).isLoading;
});

final exclusiveStoriesErrorProvider = Provider<String?>((ref) {
  return ref.watch(exclusiveStoriesProvider).error;
});