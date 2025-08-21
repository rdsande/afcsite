import '../utils/image_utils.dart';

class News {
  final int id;
  final String title;
  final String content;
  final String? image;
  final String category;
  final DateTime publishedAt;
  final String author;
  final int views;
  final bool isFeatured;
  final String? slug;

  const News({
    required this.id,
    required this.title,
    required this.content,
    this.image,
    required this.category,
    required this.publishedAt,
    required this.author,
    required this.views,
    this.isFeatured = false,
    this.slug,
  });

  factory News.fromJson(Map<String, dynamic> json) {
    // Debug: Print the raw JSON data
    print('News.fromJson: Raw JSON data: $json');
    
    // Handle image field - Laravel stores it as 'featured_image'
    final imageUrl = ImageUtils.getFullImageUrl(json['featured_image']);
    print('News.fromJson: Original image path: ${json['featured_image']}');
    print('News.fromJson: Generated image URL: $imageUrl');
    
    // Handle category - Laravel has both 'category' (string) and 'category_id' (foreign key)
    String categoryName = 'General';
    if (json['category'] != null) {
      // If category is a string, use it directly
      if (json['category'] is String) {
        categoryName = json['category'];
      }
      // If category is an object (relationship), extract the name
      else if (json['category'] is Map<String, dynamic>) {
        categoryName = json['category']['name'] ?? 'General';
      }
    }
    print('News.fromJson: Category name: $categoryName');
    
    // Handle author - Laravel stores it as 'author_id' but we want the name
    String authorName = 'Azam FC Media';
    if (json['author'] != null) {
      if (json['author'] is String) {
        authorName = json['author'];
      } else if (json['author'] is Map<String, dynamic>) {
        authorName = json['author']['name'] ?? 'Azam FC Media';
      }
    }
    print('News.fromJson: Author name: $authorName');
    
    final news = News(
      id: json['id'] ?? 0,
      title: json['title'] ?? '',
      content: json['content'] ?? json['body'] ?? json['excerpt'] ?? '',
      image: imageUrl,
      category: categoryName,
      publishedAt: json['published_at'] != null 
          ? DateTime.parse(json['published_at']) 
          : DateTime.now(),
      author: authorName,
      views: json['views'] ?? 0,
      isFeatured: json['is_featured'] ?? json['featured'] ?? false,
      slug: json['slug'],
    );
    
    print('News.fromJson: Created news object with image: ${news.image}');
    return news;
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'title': title,
      'content': content,
      'image': image,
      'category': category,
      'publishedAt': publishedAt.toIso8601String(),
      'author': author,
      'views': views,
      'isFeatured': isFeatured,
      'slug': slug,
    };
  }

  String get formattedDate {
    final now = DateTime.now();
    final difference = now.difference(publishedAt);
    
    if (difference.inDays == 0) {
      if (difference.inHours == 0) {
        return '${difference.inMinutes} minutes ago';
      }
      return '${difference.inHours} hours ago';
    } else if (difference.inDays == 1) {
      return 'Yesterday';
    } else if (difference.inDays < 7) {
      return '${difference.inDays} days ago';
    } else {
      return '${publishedAt.day}/${publishedAt.month}/${publishedAt.year}';
    }
  }
}
