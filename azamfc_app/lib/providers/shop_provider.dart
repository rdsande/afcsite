import 'package:flutter_riverpod/flutter_riverpod.dart';
import '../models/product.dart';
import '../services/api_service.dart';

class ShopState {
  final List<Product> products;
  final List<Product> featuredProducts;
  final Map<String, List<Product>> productsByCategory;
  final bool isLoading;
  final String? error;

  ShopState({
    this.products = const [],
    this.featuredProducts = const [],
    this.productsByCategory = const {},
    this.isLoading = false,
    this.error,
  });

  ShopState copyWith({
    List<Product>? products,
    List<Product>? featuredProducts,
    Map<String, List<Product>>? productsByCategory,
    bool? isLoading,
    String? error,
  }) {
    return ShopState(
      products: products ?? this.products,
      featuredProducts: featuredProducts ?? this.featuredProducts,
      productsByCategory: productsByCategory ?? this.productsByCategory,
      isLoading: isLoading ?? this.isLoading,
      error: error,
    );
  }
}

class ShopNotifier extends StateNotifier<ShopState> {
  final ApiService _apiService;

  ShopNotifier(this._apiService) : super(ShopState());

  Future<void> fetchProducts() async {
    state = state.copyWith(isLoading: true, error: null);
    try {
      final products = await _apiService.getProducts();
      state = state.copyWith(
        products: products,
        isLoading: false,
      );
    } catch (e) {
      state = state.copyWith(
        isLoading: false,
        error: 'Failed to load products: $e',
      );
    }
  }

  Future<void> fetchFeaturedProducts() async {
    state = state.copyWith(isLoading: true, error: null);
    try {
      final featuredProducts = await _apiService.getFeaturedProducts();
      state = state.copyWith(
        featuredProducts: featuredProducts,
        isLoading: false,
      );
    } catch (e) {
      state = state.copyWith(
        isLoading: false,
        error: 'Failed to load featured products: $e',
      );
    }
  }

  Future<void> fetchProductsByCategory(String category) async {
    state = state.copyWith(isLoading: true, error: null);
    try {
      final products = await _apiService.getProductsByCategory(category);
      final updatedCategories = Map<String, List<Product>>.from(state.productsByCategory);
      updatedCategories[category] = products;
      
      state = state.copyWith(
        productsByCategory: updatedCategories,
        isLoading: false,
      );
    } catch (e) {
      state = state.copyWith(
        isLoading: false,
        error: 'Failed to load products for category $category: $e',
      );
    }
  }

  Future<Product?> getProductDetail(int productId) async {
    try {
      return await _apiService.getProductDetail(productId);
    } catch (e) {
      state = state.copyWith(error: 'Failed to load product detail: $e');
      return null;
    }
  }

  void clearError() {
    state = state.copyWith(error: null);
  }
}

// Providers
final apiServiceProvider = Provider<ApiService>((ref) => ApiService());

final shopProvider = StateNotifierProvider<ShopNotifier, ShopState>((ref) {
  final apiService = ref.watch(apiServiceProvider);
  return ShopNotifier(apiService);
});

// Convenience providers
final productsProvider = Provider<List<Product>>((ref) {
  return ref.watch(shopProvider).products;
});

final featuredProductsProvider = Provider<List<Product>>((ref) {
  return ref.watch(shopProvider).featuredProducts;
});

final shopLoadingProvider = Provider<bool>((ref) {
  return ref.watch(shopProvider).isLoading;
});

final shopErrorProvider = Provider<String?>((ref) {
  return ref.watch(shopProvider).error;
});

final productsByCategoryProvider = Provider.family<List<Product>, String>((ref, category) {
  return ref.watch(shopProvider).productsByCategory[category] ?? [];
});

// Product categories
final productCategoriesProvider = Provider<List<String>>((ref) {
  return ['home', 'away', 'third', 'training', 'merchandise'];
});