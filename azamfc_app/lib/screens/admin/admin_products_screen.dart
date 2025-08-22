import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:go_router/go_router.dart';
import 'package:cached_network_image/cached_network_image.dart';
import '../../constants/app_colors.dart';
import '../../providers/shop_provider.dart';
import '../../providers/language_provider.dart';
import '../../models/product.dart';
// import 'add_edit_product_screen.dart'; // Will be created next

class AdminProductsScreen extends ConsumerStatefulWidget {
  const AdminProductsScreen({super.key});

  @override
  ConsumerState<AdminProductsScreen> createState() => _AdminProductsScreenState();
}

class _AdminProductsScreenState extends ConsumerState<AdminProductsScreen> {
  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addPostFrameCallback((_) {
      ref.read(shopProvider.notifier).fetchProducts();
    });
  }

  @override
  Widget build(BuildContext context) {
    final isLoading = ref.watch(shopLoadingProvider);
    final error = ref.watch(shopErrorProvider);
    final products = ref.watch(productsProvider);
    final locale = ref.watch(languageProviderProvider);
    final isEnglish = locale.languageCode == 'en';

    return Scaffold(
      backgroundColor: AppColors.backgroundColor,
      appBar: AppBar(
        title: Text(
          isEnglish ? 'Manage Products' : 'Simamia Bidhaa',
          style: const TextStyle(
            fontWeight: FontWeight.bold,
            color: AppColors.textPrimary,
          ),
        ),
        backgroundColor: AppColors.backgroundColor,
        elevation: 0,
        actions: [
          IconButton(
            icon: const Icon(Icons.add, color: AppColors.primaryBlue),
            onPressed: () {
              // TODO: Navigate to AddEditProductScreen
              ScaffoldMessenger.of(context).showSnackBar(
                const SnackBar(content: Text('Add product feature coming soon')),
              );
            },
          ),
        ],
      ),
      body: RefreshIndicator(
        onRefresh: () async {
          await ref.read(shopProvider.notifier).fetchProducts();
        },
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(16),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              if (error != null) _buildErrorWidget(error, isEnglish),
              if (isLoading) _buildLoadingWidget(),
              if (!isLoading && error == null) ...[
                Text(
                  isEnglish ? 'All Products (${products.length})' : 'Bidhaa Zote (${products.length})',
                  style: Theme.of(context).textTheme.titleLarge?.copyWith(
                    fontWeight: FontWeight.w700,
                    color: AppColors.primaryBlue,
                  ),
                ),
                const SizedBox(height: 16),
                if (products.isEmpty)
                  _buildEmptyState(isEnglish)
                else
                  _buildProductsList(products, isEnglish),
              ],
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildErrorWidget(String error, bool isEnglish) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.red.shade50,
        borderRadius: BorderRadius.circular(8),
        border: Border.all(color: Colors.red.shade200),
      ),
      child: Row(
        children: [
          Icon(Icons.error_outline, color: Colors.red.shade600),
          const SizedBox(width: 12),
          Expanded(
            child: Text(
              error,
              style: TextStyle(color: Colors.red.shade800),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildLoadingWidget() {
    return const Center(
      child: Padding(
        padding: EdgeInsets.all(32),
        child: CircularProgressIndicator(),
      ),
    );
  }

  Widget _buildEmptyState(bool isEnglish) {
    return Center(
      child: Column(
        children: [
          const SizedBox(height: 64),
          Icon(
            Icons.inventory_2_outlined,
            size: 80,
            color: AppColors.textSecondary,
          ),
          const SizedBox(height: 16),
          Text(
            isEnglish ? 'No products found' : 'Hakuna bidhaa zilizopatikana',
            style: Theme.of(context).textTheme.titleMedium?.copyWith(
              color: AppColors.textSecondary,
            ),
          ),
          const SizedBox(height: 8),
          Text(
            isEnglish ? 'Add your first product to get started' : 'Ongeza bidhaa ya kwanza kuanza',
            style: Theme.of(context).textTheme.bodyMedium?.copyWith(
              color: AppColors.textSecondary,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 24),
          ElevatedButton.icon(
            onPressed: () {
              // TODO: Navigate to AddEditProductScreen
              ScaffoldMessenger.of(context).showSnackBar(
                const SnackBar(content: Text('Add product feature coming soon')),
              );
            },
            icon: const Icon(Icons.add),
            label: Text(isEnglish ? 'Add Product' : 'Ongeza Bidhaa'),
            style: ElevatedButton.styleFrom(
              backgroundColor: AppColors.primaryBlue,
              foregroundColor: AppColors.white,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildProductsList(List<Product> products, bool isEnglish) {
    return ListView.builder(
      shrinkWrap: true,
      physics: const NeverScrollableScrollPhysics(),
      itemCount: products.length,
      itemBuilder: (context, index) {
        final product = products[index];
        return _buildProductCard(product, isEnglish);
      },
    );
  }

  Widget _buildProductCard(Product product, bool isEnglish) {
    return Container(
      margin: const EdgeInsets.only(bottom: 16),
      decoration: BoxDecoration(
        color: AppColors.white,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [
          BoxShadow(
            color: AppColors.shadowColorLight,
            blurRadius: 8,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Row(
          children: [
            // Product Image
            Container(
              width: 80,
              height: 80,
              decoration: BoxDecoration(
                borderRadius: BorderRadius.circular(8),
                color: AppColors.lightGrey,
              ),
              child: ClipRRect(
                borderRadius: BorderRadius.circular(8),
                child: product.image != null
                    ? CachedNetworkImage(
                        imageUrl: product.imageUrl,
                        fit: BoxFit.cover,
                        placeholder: (context, url) => Container(
                          color: AppColors.lightGrey,
                          child: const Icon(
                            Icons.image,
                            color: AppColors.textSecondary,
                          ),
                        ),
                        errorWidget: (context, url, error) => Container(
                          color: AppColors.lightGrey,
                          child: const Icon(
                            Icons.broken_image,
                            color: AppColors.textSecondary,
                          ),
                        ),
                      )
                    : const Icon(
                        Icons.image,
                        color: AppColors.textSecondary,
                      ),
              ),
            ),
            const SizedBox(width: 16),
            // Product Details
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    product.name,
                    style: Theme.of(context).textTheme.titleMedium?.copyWith(
                      fontWeight: FontWeight.w600,
                      color: AppColors.textPrimary,
                    ),
                    maxLines: 2,
                    overflow: TextOverflow.ellipsis,
                  ),
                  const SizedBox(height: 4),
                  Text(
                    product.categoryDisplayName,
                    style: Theme.of(context).textTheme.bodySmall?.copyWith(
                      color: AppColors.textSecondary,
                    ),
                  ),
                  const SizedBox(height: 4),
                  Text(
                    product.formattedPrice,
                    style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                      fontWeight: FontWeight.w600,
                      color: AppColors.primaryBlue,
                    ),
                  ),
                  const SizedBox(height: 8),
                  Row(
                    children: [
                      Container(
                        padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                        decoration: BoxDecoration(
                          color: product.isActive ? AppColors.success : AppColors.error,
                          borderRadius: BorderRadius.circular(12),
                        ),
                        child: Text(
                          product.isActive 
                              ? (isEnglish ? 'Active' : 'Hai') 
                              : (isEnglish ? 'Inactive' : 'Hahai'),
                          style: Theme.of(context).textTheme.bodySmall?.copyWith(
                            color: AppColors.white,
                            fontWeight: FontWeight.w500,
                          ),
                        ),
                      ),
                      const SizedBox(width: 8),
                      if (product.externalShopUrl != null)
                        Container(
                          padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                          decoration: BoxDecoration(
                            color: AppColors.info,
                            borderRadius: BorderRadius.circular(12),
                          ),
                          child: Text(
                            isEnglish ? 'External' : 'Nje',
                            style: Theme.of(context).textTheme.bodySmall?.copyWith(
                              color: AppColors.white,
                              fontWeight: FontWeight.w500,
                            ),
                          ),
                        ),
                    ],
                  ),
                ],
              ),
            ),
            // Action Buttons
            Column(
              children: [
                IconButton(
                  onPressed: () {
                    // TODO: Navigate to AddEditProductScreen with product
                    ScaffoldMessenger.of(context).showSnackBar(
                      const SnackBar(content: Text('Edit product feature coming soon')),
                    );
                  },
                  icon: const Icon(Icons.edit, color: AppColors.primaryBlue),
                ),
                IconButton(
                  onPressed: () => _showDeleteDialog(product, isEnglish),
                  icon: const Icon(Icons.delete, color: AppColors.error),
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }

  void _showDeleteDialog(Product product, bool isEnglish) {
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return AlertDialog(
          title: Text(isEnglish ? 'Delete Product' : 'Futa Bidhaa'),
          content: Text(
            isEnglish 
                ? 'Are you sure you want to delete "${product.name}"? This action cannot be undone.'
                : 'Una uhakika unataka kufuta "${product.name}"? Kitendo hiki hakiwezi kubatilishwa.',
          ),
          actions: [
            TextButton(
              onPressed: () => Navigator.of(context).pop(),
              child: Text(isEnglish ? 'Cancel' : 'Ghairi'),
            ),
            TextButton(
              onPressed: () {
                Navigator.of(context).pop();
                _deleteProduct(product);
              },
              style: TextButton.styleFrom(
                foregroundColor: AppColors.error,
              ),
              child: Text(isEnglish ? 'Delete' : 'Futa'),
            ),
          ],
        );
      },
    );
  }

  void _deleteProduct(Product product) {
    // TODO: Implement delete product functionality
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text('Product "${product.name}" deleted successfully'),
        backgroundColor: AppColors.success,
      ),
    );
  }
}