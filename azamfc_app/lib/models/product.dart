class Product {
  final int id;
  final String name;
  final String type;
  final String? season;
  final String? image;
  final List<String> customizationOptions;
  final double price;
  final bool isActive;
  final bool inStock;
  final String? description;
  final String? externalShopUrl;
  final List<String> sizes;
  final DateTime createdAt;
  final DateTime updatedAt;

  Product({
    required this.id,
    required this.name,
    required this.type,
    this.season,
    this.image,
    required this.customizationOptions,
    required this.price,
    required this.isActive,
    this.inStock = true,
    this.description,
    this.externalShopUrl,
    this.sizes = const [],
    required this.createdAt,
    required this.updatedAt,
  });

  factory Product.fromJson(Map<String, dynamic> json) {
    return Product(
      id: json['id'] ?? 0,
      name: json['name'] ?? '',
      type: json['type'] ?? '',
      season: json['season'],
      image: json['template_image'],
      customizationOptions: json['customization_options'] != null 
          ? List<String>.from(json['customization_options'])
          : [],
      price: double.tryParse(json['price']?.toString() ?? '0') ?? 0.0,
      isActive: json['is_active'] ?? false,
      inStock: json['in_stock'] ?? true,
      description: json['description'],
      externalShopUrl: json['external_shop_url'],
      sizes: json['sizes'] != null ? List<String>.from(json['sizes']) : [],
      createdAt: DateTime.tryParse(json['created_at'] ?? '') ?? DateTime.now(),
      updatedAt: DateTime.tryParse(json['updated_at'] ?? '') ?? DateTime.now(),
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'type': type,
      'season': season,
      'template_image': image,
      'customization_options': customizationOptions,
      'price': price,
      'is_active': isActive,
      'in_stock': inStock,
      'description': description,
      'external_shop_url': externalShopUrl,
      'sizes': sizes,
      'created_at': createdAt.toIso8601String(),
      'updated_at': updatedAt.toIso8601String(),
    };
  }

  // Helper method to get formatted price
  String get formattedPrice {
    return 'TZS ${price.toStringAsFixed(0).replaceAllMapped(
      RegExp(r'(\d{1,3})(?=(\d{3})+(?!\d))'),
      (Match m) => '${m[1]},',
    )}';
  }

  // Helper method to check if product has customization options
  bool get hasCustomization {
    return customizationOptions.isNotEmpty;
  }

  // Helper method to get product category display name
  String get categoryDisplayName {
    switch (type.toLowerCase()) {
      case 'home':
        return 'Home Kit';
      case 'away':
        return 'Away Kit';
      case 'third':
        return 'Third Kit';
      case 'training':
        return 'Training Kit';
      case 'merchandise':
        return 'Merchandise';
      default:
        return type;
    }
  }

  // Helper getter for image URL
  String get imageUrl {
    return image ?? 'https://via.placeholder.com/300x300?text=No+Image';
  }

  // Helper getter for category
  String get category {
    return categoryDisplayName;
  }
}