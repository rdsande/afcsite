import 'package:flutter/foundation.dart';

class ImageUtils {
  // Use localhost for web and Mac's IP address for mobile devices
  static String get baseUrl {
    if (kIsWeb) {
      return 'http://localhost:8000';
    } else {
      // For mobile devices, use Mac's IP address so iPhone can access the server
      return 'http://172.20.0.177:8000';
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
    String cleanPath = relativePath;
    if (cleanPath.startsWith('/')) {
      cleanPath = cleanPath.substring(1);
    }
    
    // Check if it's a storage path (uploaded files) or public path (static assets)
    String fullUrl;
    if (cleanPath.startsWith('news/') || cleanPath.startsWith('players/') || cleanPath.startsWith('teams/') || cleanPath.startsWith('storage/')) {
      // These are uploaded files in storage
      fullUrl = '$baseUrl/storage/$cleanPath';
    } else {
      // These are static assets in public directory
      fullUrl = '$baseUrl/$cleanPath';
    }
    
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
