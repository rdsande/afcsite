class ExclusiveStory {
  final int id;
  final String title;
  final String? description;
  final String type; // 'photos' or 'videos'
  final String status;
  final bool isFeatured;
  final DateTime createdAt;
  final DateTime updatedAt;
  final int mediaCount;
  final MediaThumbnail? thumbnail;
  final List<StoryMedia>? media;
  final List<ExclusiveStory>? relatedStories;
  final String? videoLink;

  ExclusiveStory({
    required this.id,
    required this.title,
    this.description,
    required this.type,
    required this.status,
    required this.isFeatured,
    required this.createdAt,
    required this.updatedAt,
    required this.mediaCount,
    this.thumbnail,
    this.media,
    this.relatedStories,
    this.videoLink,
  });

  factory ExclusiveStory.fromJson(Map<String, dynamic> json) {
    return ExclusiveStory(
      id: json['id'],
      title: json['title'],
      description: json['description'],
      type: json['type'],
      status: json['status'],
      isFeatured: json['is_featured'] ?? false,
      createdAt: DateTime.parse(json['created_at']),
      updatedAt: DateTime.parse(json['updated_at']),
      mediaCount: json['media_count'] ?? 0,
      thumbnail: json['thumbnail'] != null 
          ? MediaThumbnail.fromJson(json['thumbnail']) 
          : null,
      media: json['media'] != null
          ? (json['media'] as List)
              .map((item) => StoryMedia.fromJson(item))
              .toList()
          : null,
      relatedStories: json['related_stories'] != null
          ? (json['related_stories'] as List)
              .map((item) => ExclusiveStory.fromJson(item))
              .toList()
          : null,
      videoLink: json['video_link'],
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'title': title,
      'description': description,
      'type': type,
      'status': status,
      'is_featured': isFeatured,
      'created_at': createdAt.toIso8601String(),
      'updated_at': updatedAt.toIso8601String(),
      'media_count': mediaCount,
      'thumbnail': thumbnail?.toJson(),
      'media': media?.map((item) => item.toJson()).toList(),
      'related_stories': relatedStories?.map((item) => item.toJson()).toList(),
      'video_link': videoLink,
    };
  }

  bool get isPhotoGallery => type == 'photos';
  bool get isVideoStory => type == 'video';
  
  String get typeDisplayName => isPhotoGallery ? 'Photo Gallery' : 'Video Story';
  
  // Video link helper methods
  bool get hasVideoLink => videoLink != null && videoLink!.isNotEmpty;
  
  bool get isYouTubeVideo => hasVideoLink && (videoLink!.contains('youtube.com') || videoLink!.contains('youtu.be'));
  
  bool get isVimeoVideo => hasVideoLink && videoLink!.contains('vimeo.com');
  
  String? get youTubeVideoId {
    if (!isYouTubeVideo) return null;
    
    final uri = Uri.tryParse(videoLink!);
    if (uri == null) return null;
    
    // Handle youtube.com/watch?v=VIDEO_ID
    if (uri.host.contains('youtube.com') && uri.queryParameters.containsKey('v')) {
      return uri.queryParameters['v'];
    }
    
    // Handle youtu.be/VIDEO_ID
    if (uri.host.contains('youtu.be') && uri.pathSegments.isNotEmpty) {
      return uri.pathSegments.first;
    }
    
    return null;
  }
  
  String? get vimeoVideoId {
    if (!isVimeoVideo) return null;
    
    final uri = Uri.tryParse(videoLink!);
    if (uri == null) return null;
    
    // Handle vimeo.com/VIDEO_ID
    if (uri.host.contains('vimeo.com') && uri.pathSegments.isNotEmpty) {
      return uri.pathSegments.last;
    }
    
    return null;
  }
  
  String? get embedUrl {
    if (isYouTubeVideo && youTubeVideoId != null) {
      return 'https://www.youtube.com/embed/${youTubeVideoId!}';
    }
    
    if (isVimeoVideo && vimeoVideoId != null) {
      return 'https://player.vimeo.com/video/${vimeoVideoId!}';
    }
    
    return null;
  }
  
  String get formattedDate {
    final now = DateTime.now();
    final difference = now.difference(createdAt);
    
    if (difference.inDays > 7) {
      return '${createdAt.day}/${createdAt.month}/${createdAt.year}';
    } else if (difference.inDays > 0) {
      return '${difference.inDays} day${difference.inDays > 1 ? 's' : ''} ago';
    } else if (difference.inHours > 0) {
      return '${difference.inHours} hour${difference.inHours > 1 ? 's' : ''} ago';
    } else if (difference.inMinutes > 0) {
      return '${difference.inMinutes} minute${difference.inMinutes > 1 ? 's' : ''} ago';
    } else {
      return 'Just now';
    }
  }
}

class MediaThumbnail {
  final String url;
  final String type;

  MediaThumbnail({
    required this.url,
    required this.type,
  });

  factory MediaThumbnail.fromJson(Map<String, dynamic> json) {
    return MediaThumbnail(
      url: json['url'],
      type: json['type'],
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'url': url,
      'type': type,
    };
  }
}

class StoryMedia {
  final int id;
  final String filePath;
  final String fileType;
  final int? fileSize;
  final String url;
  final DateTime createdAt;

  StoryMedia({
    required this.id,
    required this.filePath,
    required this.fileType,
    this.fileSize,
    required this.url,
    required this.createdAt,
  });

  factory StoryMedia.fromJson(Map<String, dynamic> json) {
    return StoryMedia(
      id: json['id'],
      filePath: json['file_path'],
      fileType: json['file_type'],
      fileSize: json['file_size'],
      url: json['url'],
      createdAt: DateTime.parse(json['created_at']),
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'file_path': filePath,
      'file_type': fileType,
      'file_size': fileSize,
      'url': url,
      'created_at': createdAt.toIso8601String(),
    };
  }

  bool get isImage => fileType.startsWith('image/');
  bool get isVideo => fileType.startsWith('video/');
}

class ExclusiveStoriesResponse {
  final bool success;
  final List<ExclusiveStory> stories;
  final PaginationInfo? pagination;
  final String? message;
  final String? error;

  ExclusiveStoriesResponse({
    required this.success,
    required this.stories,
    this.pagination,
    this.message,
    this.error,
  });

  factory ExclusiveStoriesResponse.fromJson(Map<String, dynamic> json) {
    return ExclusiveStoriesResponse(
      success: json['success'] ?? false,
      stories: json['data'] != null
          ? (json['data'] is List
              ? (json['data'] as List)
                  .map((item) => ExclusiveStory.fromJson(item))
                  .toList()
              : json['data']['stories'] != null
                  ? (json['data']['stories'] as List)
                      .map((item) => ExclusiveStory.fromJson(item))
                      .toList()
                  : <ExclusiveStory>[])
          : <ExclusiveStory>[],
      pagination: json['data'] != null && json['data']['pagination'] != null
          ? PaginationInfo.fromJson(json['data']['pagination'])
          : null,
      message: json['message'],
      error: json['error'],
    );
  }
}

class PaginationInfo {
  final int currentPage;
  final int lastPage;
  final int perPage;
  final int total;
  final bool hasMorePages;

  PaginationInfo({
    required this.currentPage,
    required this.lastPage,
    required this.perPage,
    required this.total,
    required this.hasMorePages,
  });

  factory PaginationInfo.fromJson(Map<String, dynamic> json) {
    return PaginationInfo(
      currentPage: json['current_page'] ?? 1,
      lastPage: json['last_page'] ?? 1,
      perPage: json['per_page'] ?? 10,
      total: json['total'] ?? 0,
      hasMorePages: json['has_more_pages'] ?? false,
    );
  }
}