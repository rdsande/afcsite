class AppConfig {
  // API Configuration
  static const String apiBaseUrl = 'https://your-domain.com/api';
  static const String apiVersion = 'v1';
  
  // App Configuration
  static const String appName = 'Azam FC';
  static const String appVersion = '1.0.0';
  static const String appBuildNumber = '1';
  
  // Default Settings
  static const String defaultLanguage = 'sw';
  static const String defaultCountry = 'Tanzania';
  static const String defaultCurrency = 'TZS';
  
  // Image Configuration
  static const String defaultImageUrl = 'https://your-domain.com/images/default.png';
  static const String logoUrl = 'https://your-domain.com/images/logo.png';
  static const String splashImageUrl = 'https://your-domain.com/images/splash.png';
  
  // Cache Configuration
  static const Duration cacheDuration = Duration(hours: 1);
  static const int maxCacheSize = 100 * 1024 * 1024; // 100MB
  
  // Animation Configuration
  static const Duration defaultAnimationDuration = Duration(milliseconds: 300);
  static const Duration splashAnimationDuration = Duration(milliseconds: 1500);
  
  // Pagination
  static const int defaultPageSize = 20;
  static const int maxPageSize = 100;
  
  // Timeouts
  static const Duration connectionTimeout = Duration(seconds: 30);
  static const Duration receiveTimeout = Duration(seconds: 30);
  
  // Feature Flags
  static const bool enablePushNotifications = true;
  static const bool enableOfflineMode = true;
  static const bool enableAnalytics = true;
  static const bool enableCrashReporting = true;
  
  // Social Media
  static const String facebookUrl = 'https://facebook.com/azamfc';
  static const String twitterUrl = 'https://twitter.com/azamfc';
  static const String instagramUrl = 'https://instagram.com/azamfc';
  static const String youtubeUrl = 'https://youtube.com/azamfc';
  
  // Support
  static const String supportEmail = 'support@azamfc.co.tz';
  static const String supportPhone = '+255 123 456 789';
  static const String websiteUrl = 'https://azamfc.co.tz';
  
  // Shop
  static const String shopUrl = 'https://shop.azamfc.co.tz';
  
  // Privacy and Terms
  static const String privacyPolicyUrl = 'https://azamfc.co.tz/privacy';
  static const String termsOfServiceUrl = 'https://azamfc.co.tz/terms';
  
  // Development
  static const bool isDevelopment = true;
  static const bool enableDebugLogging = true;
  static const bool enablePerformanceMonitoring = true;
}
