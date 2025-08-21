import 'dart:convert';
import 'lib/models/news.dart';

void main() async {
  print('Testing News model and ImageUtils...');
  
  // Sample JSON data from the API
  final sampleJson = {
    "id": 5,
    "title": "Azam FC to play Simba in upcoming games",
    "slug": "azam-fc-to-play-simba-in-upcoming-games",
    "excerpt": "fsfsfsdf fdsf fsdfsd fsfd sdf",
    "content": "<p>sdfsdfsd sdfds fsdf dsfsfds fsfdsfsfsdfsdfsdf</p>",
    "featured_image": "news/p788s3cC9ptWiMnMC4Ky2CFiCubxEcirH0FmO8G9.png",
    "category": {
      "id": 1,
      "name": "Latest News",
      "slug": "latest-news",
      "description": "Most recent news and updates",
      "color": "#007bff",
      "is_active": true,
      "sort_order": 1,
      "created_at": "2025-08-19T08:47:27.000000Z",
      "updated_at": "2025-08-19T08:47:27.000000Z"
    },
    "is_published": true,
    "is_featured": true,
    "published_at": "2025-08-12T11:06:34.000000Z",
    "author_id": 1,
    "views": 0,
    "created_at": "2025-08-19T10:09:45.000000Z",
    "updated_at": "2025-08-19T11:06:34.000000Z",
    "category_id": 1,
    "author": {
      "id": 1,
      "name": "Super Administrator",
      "email": "admin@azamfc.com",
      "email_verified_at": "2025-08-19T06:43:15.000000Z",
      "created_at": "2025-08-19T06:43:15.000000Z",
      "updated_at": "2025-08-21T06:00:18.000000Z",
      "role": "super_admin",
      "is_active": true,
      "last_login_at": "2025-08-21T06:00:18.000000Z",
      "profile_image": "profile-images/7cWpG7JIMhXgPQxCbDrIa2N9dFnrUjZQ83ebznxy.png"
    }
  };
  
  try {
    // Create News object from JSON
    final news = News.fromJson(sampleJson);
    
    print('\n=== News Object Created Successfully ===');
    print('Title: ${news.title}');
    print('Image URL: ${news.image}');
    print('Category: ${news.category}');
    print('Author: ${news.author}');
    
    // Test the image URL
    if (news.image != null) {
      print('\n=== Testing Image URL ===');
      print('Full Image URL: ${news.image}');
      
      // Check if the URL is valid
      if (news.image!.startsWith('http://') || news.image!.startsWith('https://')) {
        print('✅ Image URL is properly formatted');
      } else {
        print('❌ Image URL is not properly formatted');
      }
    } else {
      print('❌ Image URL is null');
    }
    
  } catch (e, stackTrace) {
    print('❌ Error creating News object: $e');
    print('Stack trace: $stackTrace');
  }
}
