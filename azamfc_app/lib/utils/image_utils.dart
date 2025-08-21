import 'package:flutter/foundation.dart';

class ImageUtils {
  // Use localhost for web and 127.0.0.1 for mobile (USB connection)
  static String get baseUrl {
    if (kIsWeb) {
      return 'http://localhost:8000';
    } else {
      // For mobile devices connected via USB cable, use 127.0.0.1
      return 'http://127.0.0.1:8000';
    }
  }
  
  /// Convert relative image path to full URL
  static String? getFullImageUrl(String? relativePath) {
    print('ImageUtils.getFullImageUrl called with: $relativePath');
    
    if (relativePath == null || relativePath.isEmpty) {
      print('ImageUtils: relativePath is null or empty');
      return null;
    }
    
    // If it's already a full URL, return as is
    if (relativePath.startsWith('http://') || relativePath.startsWith('https://')) {
      print('ImageUtils: relativePath is already a full URL: $relativePath');
      return relativePath;
    }
    
    // Remove leading slash if present
    if (relativePath.startsWith('/')) {
      relativePath = relativePath.substring(1);
    }
    
    final fullUrl = '$baseUrl/storage/$relativePath';
    print('ImageUtils: Generated full URL: $fullUrl');
    return fullUrl;
  }
  
  /// Get placeholder image URL for missing images
  static String getPlaceholderImageUrl() {
    return 'https://via.placeholder.com/300x200/1976D2/FFFFFF?text=No+Image';
  }
  
  /// Check if image URL is valid
  static bool isValidImageUrl(String? url) {
    return url != null && url.isNotEmpty && 
           (url.startsWith('http://') || url.startsWith('https://'));
  }
}
