import 'package:flutter_riverpod/flutter_riverpod.dart';
import '../models/fan.dart';
import '../services/api_service.dart';

class FansState {
  final List<Fan> fans;
  final FansPagination? pagination;
  final bool isLoading;
  final bool isLoadingMore;
  final String? error;
  final String searchQuery;
  final String? selectedRegion;
  final String sortBy;
  final String sortOrder;

  const FansState({
    this.fans = const [],
    this.pagination,
    this.isLoading = false,
    this.isLoadingMore = false,
    this.error,
    this.searchQuery = '',
    this.selectedRegion,
    this.sortBy = 'points',
    this.sortOrder = 'desc',
  });

  bool get hasNextPage => pagination?.hasNextPage ?? false;
  bool get hasPreviousPage => pagination?.hasPreviousPage ?? false;

  FansState copyWith({
    List<Fan>? fans,
    FansPagination? pagination,
    bool? isLoading,
    bool? isLoadingMore,
    String? error,
    String? searchQuery,
    String? selectedRegion,
    String? sortBy,
    String? sortOrder,
  }) {
    return FansState(
      fans: fans ?? this.fans,
      pagination: pagination ?? this.pagination,
      isLoading: isLoading ?? this.isLoading,
      isLoadingMore: isLoadingMore ?? this.isLoadingMore,
      error: error ?? this.error,
      searchQuery: searchQuery ?? this.searchQuery,
      selectedRegion: selectedRegion ?? this.selectedRegion,
      sortBy: sortBy ?? this.sortBy,
      sortOrder: sortOrder ?? this.sortOrder,
    );
  }
}

class FansNotifier extends StateNotifier<FansState> {
  FansNotifier() : super(const FansState());
  final ApiService _apiService = ApiService();

  // Load fans with optional filters
  Future<void> loadFans({
    bool refresh = false,
    String? search,
    String? region,
    String? sortBy,
    String? sortOrder,
  }) async {
    if (refresh) {
      state = state.copyWith(
        fans: [],
        pagination: null,
      );
    }

    state = state.copyWith(
      isLoading: true,
      error: null,
      searchQuery: search ?? state.searchQuery,
      selectedRegion: region ?? state.selectedRegion,
      sortBy: sortBy ?? state.sortBy,
      sortOrder: sortOrder ?? state.sortOrder,
    );

    try {
      final response = await _apiService.getFans(
        page: 1,
        search: state.searchQuery.isEmpty ? null : state.searchQuery,
        region: state.selectedRegion,
        sortBy: state.sortBy,
        sortOrder: state.sortOrder,
      );

      state = state.copyWith(
        fans: response.fans,
        pagination: response.pagination,
        isLoading: false,
        error: null,
      );
    } catch (e) {
      state = state.copyWith(
        isLoading: false,
        error: e.toString(),
      );
      print('Error loading fans: $e');
    }
  }

  // Load more fans (pagination)
  Future<void> loadMoreFans() async {
    if (state.isLoadingMore || !state.hasNextPage) return;

    state = state.copyWith(isLoadingMore: true);

    try {
      final nextPage = (state.pagination?.currentPage ?? 0) + 1;
      final response = await _apiService.getFans(
        page: nextPage,
        search: state.searchQuery.isEmpty ? null : state.searchQuery,
        region: state.selectedRegion,
        sortBy: state.sortBy,
        sortOrder: state.sortOrder,
      );

      state = state.copyWith(
        fans: [...state.fans, ...response.fans],
        pagination: response.pagination,
        isLoadingMore: false,
        error: null,
      );
    } catch (e) {
      state = state.copyWith(
        isLoadingMore: false,
        error: e.toString(),
      );
      print('Error loading more fans: $e');
    }
  }

  // Search fans
  Future<void> searchFans(String query) async {
    await loadFans(refresh: true, search: query);
  }

  // Filter by region
  Future<void> filterByRegion(String? region) async {
    await loadFans(refresh: true, region: region);
  }

  // Sort fans
  Future<void> sortFans(String sortBy, String sortOrder) async {
    await loadFans(refresh: true, sortBy: sortBy, sortOrder: sortOrder);
  }

  // Clear filters
  Future<void> clearFilters() async {
    await loadFans(
      refresh: true,
      search: '',
      region: null,
      sortBy: 'points',
      sortOrder: 'desc',
    );
  }

  // Refresh fans
  Future<void> refreshFans() async {
    await loadFans(refresh: true);
  }

  // Get fan by ID
  Fan? getFanById(int id) {
    try {
      return state.fans.firstWhere((fan) => fan.id == id);
    } catch (e) {
      return null;
    }
  }

  // Clear error
  void clearError() {
    state = state.copyWith(error: null);
  }
}

// Provider
final fansProvider = StateNotifierProvider<FansNotifier, FansState>((ref) {
  return FansNotifier();
});