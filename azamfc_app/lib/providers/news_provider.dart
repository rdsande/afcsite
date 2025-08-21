import 'package:flutter_riverpod/flutter_riverpod.dart';
import '../models/news.dart';
import '../services/api_service.dart';

// News state class
class NewsState {
  final List<News> featuredNews;
  final List<News> latestNews;
  final bool isLoading;
  final String? error;

  const NewsState({
    this.featuredNews = const [],
    this.latestNews = const [],
    this.isLoading = false,
    this.error,
  });

  NewsState copyWith({
    List<News>? featuredNews,
    List<News>? latestNews,
    bool? isLoading,
    String? error,
  }) {
    return NewsState(
      featuredNews: featuredNews ?? this.featuredNews,
      latestNews: latestNews ?? this.latestNews,
      isLoading: isLoading ?? this.isLoading,
      error: error ?? this.error,
    );
  }
}

// News provider
class NewsNotifier extends StateNotifier<NewsState> {
  final ApiService _apiService;

  NewsNotifier(this._apiService) : super(const NewsState());

  // Fetch featured news
  Future<void> fetchFeaturedNews() async {
    state = state.copyWith(isLoading: true, error: null);
    
    try {
      final featuredNews = await _apiService.getFeaturedNews();
      state = state.copyWith(
        featuredNews: featuredNews,
        isLoading: false,
      );
    } catch (e) {
      state = state.copyWith(
        isLoading: false,
        error: 'Failed to load featured news: $e',
      );
    }
  }

  // Fetch latest news
  Future<void> fetchLatestNews({int page = 1}) async {
    if (page == 1) {
      state = state.copyWith(isLoading: true, error: null);
    }
    
    try {
      final latestNews = await _apiService.getLatestNews(page: page);
      
      if (page == 1) {
        state = state.copyWith(
          latestNews: latestNews,
          isLoading: false,
        );
      } else {
        // Append to existing news for pagination
        state = state.copyWith(
          latestNews: [...state.latestNews, ...latestNews],
          isLoading: false,
        );
      }
    } catch (e) {
      state = state.copyWith(
        isLoading: false,
        error: 'Failed to load latest news: $e',
      );
    }
  }

  // Fetch both featured and latest news
  Future<void> fetchAllNews() async {
    await Future.wait([
      fetchFeaturedNews(),
      fetchLatestNews(),
    ]);
  }

  // Get news detail
  Future<News?> getNewsDetail(int newsId) async {
    try {
      return await _apiService.getNewsDetail(newsId);
    } catch (e) {
      state = state.copyWith(error: 'Failed to load news detail: $e');
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

final newsProvider = StateNotifierProvider<NewsNotifier, NewsState>((ref) {
  final apiService = ref.watch(apiServiceProvider);
  return NewsNotifier(apiService);
});

// Convenience providers
final featuredNewsProvider = Provider<List<News>>((ref) {
  return ref.watch(newsProvider).featuredNews;
});

final latestNewsProvider = Provider<List<News>>((ref) {
  return ref.watch(newsProvider).latestNews;
});

final newsLoadingProvider = Provider<bool>((ref) {
  return ref.watch(newsProvider).isLoading;
});

final newsErrorProvider = Provider<String?>((ref) {
  return ref.watch(newsProvider).error;
});