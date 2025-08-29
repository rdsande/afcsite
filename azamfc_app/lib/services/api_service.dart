import 'package:dio/dio.dart';
import 'package:flutter/foundation.dart';
import '../models/news.dart';
import '../models/fixture.dart';
import '../models/player.dart';
import '../models/fan.dart';
import '../models/product.dart';
import '../models/exclusive_story.dart';

class ApiService {
  // Use localhost for web and network IP for mobile to match CORS configuration
  static String get baseUrl {
    if (kIsWeb) {
      return 'http://localhost:8000/api/mobile';
    } else {
      // For mobile devices, use the computer's local network IP
      return 'http://172.20.0.177:8000/api/mobile';
    }
  }
  
  late final Dio _dio;
  
  ApiService() {
    _dio = Dio(BaseOptions(
      baseUrl: baseUrl,
      connectTimeout: const Duration(seconds: 10),
      receiveTimeout: const Duration(seconds: 10),
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
    ));
    
    // Add interceptors for logging and error handling
    _dio.interceptors.add(LogInterceptor(
      requestBody: true,
      responseBody: true,
      logPrint: (obj) => print(obj),
    ));
  }

  // App Configuration
  Future<Map<String, dynamic>> getAppConfig() async {
    try {
      final response = await _dio.get('/config');
      return response.data['data'];
    } catch (e) {
      print('Error fetching app config: $e');
      return {};
    }
  }

  Future<Map<String, dynamic>> getSplashScreen() async {
    try {
      final response = await _dio.get('/splash-screen');
      return response.data['data'];
    } catch (e) {
      print('Error fetching splash screen: $e');
      return {};
    }
  }

  // News API calls
  Future<List<News>> getFeaturedNews() async {
    try {
      final response = await _dio.get('/news/featured');
      final List<dynamic> newsData = response.data['data'];
      return newsData.map((json) => News.fromJson(json)).toList();
    } catch (e) {
      print('Error fetching featured news: $e');
      // Return mock data as fallback
      return _getMockFeaturedNews();
    }
  }

  Future<List<News>> getLatestNews({int page = 1}) async {
    try {
      final response = await _dio.get('/news', queryParameters: {'page': page});
      final List<dynamic> newsData = response.data['data'];
      return newsData.map((json) => News.fromJson(json)).toList();
    } catch (e) {
      print('Error fetching latest news: $e');
      // Return mock data as fallback
      return _getMockLatestNews();
    }
  }

  Future<News?> getNewsDetail(int newsId) async {
    try {
      final response = await _dio.get('/news/$newsId');
      return News.fromJson(response.data['data']);
    } catch (e) {
      print('Error fetching news detail: $e');
      return null;
    }
  }

  // Fixtures API calls
  Future<List<Fixture>> getUpcomingFixtures() async {
    try {
      final response = await _dio.get('/fixtures/upcoming');
      final List<dynamic> fixturesData = response.data['data'];
      return fixturesData.map((json) => Fixture.fromJson(json)).toList();
    } catch (e) {
      print('Error fetching upcoming fixtures: $e');
      return _getMockUpcomingFixtures();
    }
  }

  Future<List<Fixture>> getRecentResults() async {
    try {
      final response = await _dio.get('/fixtures/results');
      final List<dynamic> fixturesData = response.data['data'];
      return fixturesData.map((json) => Fixture.fromJson(json)).toList();
    } catch (e) {
      print('Error fetching recent results: $e');
      return _getMockRecentResults();
    }
  }

  Future<List<Fixture>> getAllFixtures({int page = 1}) async {
    try {
      final response = await _dio.get('/fixtures', queryParameters: {'page': page});
      final List<dynamic> fixturesData = response.data['data'];
      return fixturesData.map((json) => Fixture.fromJson(json)).toList();
    } catch (e) {
      print('Error fetching all fixtures: $e');
      return [];
    }
  }

  Future<Fixture?> getFixtureDetail(int fixtureId) async {
    try {
      final response = await _dio.get('/fixtures/$fixtureId');
      return Fixture.fromJson(response.data['data']);
    } catch (e) {
      print('Error fetching fixture detail: $e');
      return null;
    }
  }

  // Players API calls
  Future<Map<String, List<Player>>> getSeniorPlayers() async {
    try {
      final response = await _dio.get('/players/senior');
      final Map<String, dynamic> playersData = response.data['data'];
      
      Map<String, List<Player>> groupedPlayers = {};
      playersData.forEach((position, players) {
        groupedPlayers[position] = (players as List)
            .map((json) => Player.fromJson(json))
            .toList();
      });
      
      return groupedPlayers;
    } catch (e) {
      print('Error fetching senior players: $e');
      return _getMockSeniorPlayers();
    }
  }

  Future<Map<String, List<Player>>> getAcademyPlayers(String team) async {
    try {
      final response = await _dio.get('/players/academy/$team');
      final Map<String, dynamic> playersData = response.data['data'];
      
      Map<String, List<Player>> groupedPlayers = {};
      playersData.forEach((position, players) {
        groupedPlayers[position] = (players as List)
            .map((json) => Player.fromJson(json))
            .toList();
      });
      
      return groupedPlayers;
    } catch (e) {
      print('Error fetching academy players: $e');
      return {};
    }
  }

  Future<List<Player>> getAllPlayers({int page = 1, String? position, String? team}) async {
    try {
      final Map<String, dynamic> params = {'page': page};
      if (position != null) params['position'] = position;
      if (team != null) params['team'] = team;
      
      final response = await _dio.get('/players', queryParameters: params);
      final List<dynamic> playersData = response.data['data'];
      return playersData.map((json) => Player.fromJson(json)).toList();
    } catch (e) {
      print('Error fetching all players: $e');
      return _getMockAllPlayers();
    }
  }

  Future<Player?> getPlayerDetail(int playerId) async {
    try {
      final response = await _dio.get('/players/$playerId');
      return Player.fromJson(response.data['data']);
    } catch (e) {
      print('Error fetching player detail: $e');
      return null;
    }
  }

  // Shop/Products API calls
  Future<List<Product>> getProducts() async {
    try {
      final response = await _dio.get('/shop/products');
      final List<dynamic> productsData = response.data['data'];
      return productsData.map((json) => Product.fromJson(json)).toList();
    } catch (e) {
      print('Error fetching products: $e');
      return _getMockProducts();
    }
  }

  Future<List<Product>> getFeaturedProducts() async {
    try {
      final response = await _dio.get('/shop/products/featured');
      final List<dynamic> productsData = response.data['data'];
      return productsData.map((json) => Product.fromJson(json)).toList();
    } catch (e) {
      print('Error fetching featured products: $e');
      return _getMockFeaturedProducts();
    }
  }

  Future<List<Product>> getProductsByCategory(String category) async {
    try {
      final response = await _dio.get('/shop/products/category/$category');
      final List<dynamic> productsData = response.data['data'];
      return productsData.map((json) => Product.fromJson(json)).toList();
    } catch (e) {
      print('Error fetching products by category: $e');
      return _getMockProductsByCategory(category);
    }
  }

  Future<Product?> getProductDetail(int productId) async {
    try {
      final response = await _dio.get('/shop/products/$productId');
      return Product.fromJson(response.data['data']);
    } catch (e) {
      print('Error fetching product detail: $e');
      return null;
    }
  }

  // Fan authentication
  Future<Map<String, dynamic>?> fanLogin(String phone, String password) async {
    try {
      final loginData = {
        'phone': phone,
        'password': password,
      };
      
      print('Sending login data: $loginData');
      final response = await _dio.post('/fan/login', data: loginData);
      print('Login response: ${response.statusCode} - ${response.data}');
      
      if (response.statusCode == 200) {
        return response.data['data'];
      }
      print('Login failed with status: ${response.statusCode}');
      return null;
    } catch (e) {
      print('Error during fan login: $e');
      if (e is DioException) {
        print('DioException details: ${e.response?.data}');
        print('Status code: ${e.response?.statusCode}');
      }
      return null;
    }
  }

  Future<Map<String, dynamic>?> fanRegister({
    required String firstName,
    required String lastName,
    String? email,
    required String phone,
    required String password,
    required String gender,
    required DateTime dateOfBirth,
    required String region,
    required String district,
  }) async {
    try {
      final Map<String, dynamic> data = {
        'first_name': firstName,
        'last_name': lastName,
        'phone': phone,
        'password': password,
        'password_confirmation': password,
        'gender': gender,
        'date_of_birth': dateOfBirth.toIso8601String().split('T')[0],
        'region': region,
        'district': district,
      };
      
      // Only add email if it's provided
      if (email != null && email.isNotEmpty) {
        data['email'] = email;
      }
      
      print('Sending registration data: $data');
      final response = await _dio.post('/fan/register', data: data);
      print('Registration response: ${response.statusCode} - ${response.data}');
      
      if (response.statusCode == 201) {
        return response.data['data'];
      }
      print('Registration failed with status: ${response.statusCode}');
      return null;
    } catch (e) {
      print('Error during fan registration: $e');
      if (e is DioException) {
        print('DioException details: ${e.response?.data}');
        print('Status code: ${e.response?.statusCode}');
      }
      return null;
    }
  }

  Future<Fan?> getFanProfile(String token) async {
    try {
      final response = await _dio.get('/fan/profile', options: Options(
        headers: {'Authorization': 'Bearer $token'}
      ));
      
      if (response.statusCode == 200) {
        return Fan.fromJson(response.data['data']);
      }
      return null;
    } catch (e) {
      print('Error fetching fan profile: $e');
      return null;
    }
  }

  Future<bool> updateFanProfile(String token, Map<String, dynamic> profileData) async {
    try {
      final response = await _dio.put('/fan/profile', 
        data: profileData,
        options: Options(headers: {'Authorization': 'Bearer $token'})
      );
      
      return response.statusCode == 200;
    } catch (e) {
      print('Error updating fan profile: $e');
      return false;
    }
  }

  Future<bool> fanLogout(String token) async {
    try {
      final response = await _dio.post('/fan/logout', options: Options(
        headers: {'Authorization': 'Bearer $token'}
      ));
      
      return response.statusCode == 200;
    } catch (e) {
      print('Error during fan logout: $e');
      return false;
    }
  }

  Future<Map<String, dynamic>?> getFanPoints(String token) async {
    try {
      final response = await _dio.get('/fan/points', options: Options(
        headers: {'Authorization': 'Bearer $token'}
      ));
      
      if (response.statusCode == 200) {
        return response.data['data'];
      }
      return null;
    } catch (e) {
      print('Error fetching fan points: $e');
      return null;
    }
  }

  // Jersey API methods
  Future<Map<String, dynamic>?> getFanJersey(String token) async {
    try {
      final response = await _dio.get('/fan/jersey', options: Options(
        headers: {'Authorization': 'Bearer $token'}
      ));
      
      if (response.statusCode == 200) {
        return response.data['data'];
      }
      return null;
    } catch (e) {
      print('Error fetching fan jersey: $e');
      return null;
    }
  }

  Future<Map<String, dynamic>?> updateFanJersey(String token, String jerseyName, int jerseyNumber, {String? jerseyType}) async {
    try {
      final data = {
        'jersey_name': jerseyName,
        'jersey_number': jerseyNumber,
      };
      
      if (jerseyType != null) {
        data['jersey_type'] = jerseyType;
      }
      
      final response = await _dio.put('/fan/jersey', 
        data: data,
        options: Options(headers: {'Authorization': 'Bearer $token'})
      );
      
      if (response.statusCode == 200) {
        return response.data;
      }
      return null;
    } catch (e) {
      print('Error updating fan jersey: $e');
      return null;
    }
  }

  // Get all available jersey types with their details
  Future<Map<String, dynamic>?> getJerseyTypes() async {
    try {
      final response = await _dio.get('/mobile/jerseys/types');
      
      if (response.statusCode == 200) {
        return response.data;
      }
      return null;
    } catch (e) {
      print('Error fetching jersey types: $e');
      return null;
    }
  }

  // Get all active jerseys
  Future<List<Map<String, dynamic>>> getAllJerseys() async {
    try {
      final response = await _dio.get('/mobile/jerseys');
      
      if (response.statusCode == 200) {
        final List<dynamic> jerseysData = response.data['data'];
        return jerseysData.cast<Map<String, dynamic>>();
      }
      return [];
    } catch (e) {
      print('Error fetching jerseys: $e');
      return [];
    }
  }

  // Get jersey by type (home, away, third)
  Future<Map<String, dynamic>?> getJerseyByType(String type) async {
    try {
      final response = await _dio.get('/mobile/jerseys/type/$type');
      
      if (response.statusCode == 200) {
        return response.data['data'];
      }
      return null;
    } catch (e) {
      print('Error fetching jersey by type: $e');
      return null;
    }
  }

  // Admin Notices API methods
  Future<List<Map<String, dynamic>>> getAdminNotices() async {
    try {
      final response = await _dio.get('/admin-notices/dashboard');
      
      if (response.statusCode == 200) {
        final List<dynamic> noticesData = response.data['data'];
        return noticesData.cast<Map<String, dynamic>>();
      }
      return [];
    } catch (e) {
      print('Error fetching admin notices: $e');
      return [];
    }
  }

  // Mock data methods for fallback when API is unavailable
  List<News> _getMockFeaturedNews() {
    return [
      News(
        id: 1,
        title: 'Azam FC Wins Championship',
        content: 'Azam FC has won the championship in a thrilling match against their rivals. The team showed exceptional performance throughout the season.',
        category: 'Match Results',
        publishedAt: DateTime.now().subtract(Duration(days: 1)),
        author: 'Sports Reporter',
        views: 1250,
        isFeatured: true,
      ),
      News(
        id: 2,
        title: 'New Player Signing',
        content: 'Azam FC announces the signing of a new striker who will strengthen the team for the upcoming season.',
        category: 'Transfers',
        publishedAt: DateTime.now().subtract(Duration(days: 2)),
        author: 'Transfer News',
        views: 890,
        isFeatured: true,
      ),
    ];
  }

  List<News> _getMockLatestNews() {
    return [
      News(
        id: 3,
        title: 'Training Camp Update',
        content: 'The team is currently in intensive training preparing for the next season. Players are showing great dedication.',
        category: 'Training',
        publishedAt: DateTime.now().subtract(Duration(hours: 6)),
        author: 'Team Reporter',
        views: 456,
      ),
      News(
        id: 4,
        title: 'Fan Meet and Greet',
        content: 'Join us for a special fan meet and greet event with your favorite Azam FC players this weekend.',
        category: 'Events',
        publishedAt: DateTime.now().subtract(Duration(hours: 12)),
        author: 'Event Coordinator',
        views: 678,
      ),
    ];
  }

  // Mock data methods for fallback when API is unavailable
  List<Fixture> _getMockUpcomingFixtures() {
    return [
      Fixture(
        id: 1,
        homeTeam: 'Azam FC',
        awayTeam: 'Simba SC',
        matchDate: DateTime.now().add(Duration(days: 7)),
        venue: 'Azam Complex',
        tournament: 'Premier League',
        status: 'upcoming',
      ),
      Fixture(
        id: 2,
        homeTeam: 'Young Africans',
        awayTeam: 'Azam FC',
        matchDate: DateTime.now().add(Duration(days: 14)),
        venue: 'Benjamin Mkapa Stadium',
        tournament: 'Premier League',
        status: 'upcoming',
      ),
    ];
  }

  List<Fixture> _getMockRecentResults() {
    return [
      Fixture(
        id: 3,
        homeTeam: 'Azam FC',
        awayTeam: 'Mbeya City',
        matchDate: DateTime.now().subtract(Duration(days: 7)),
        venue: 'Azam Complex',
        tournament: 'Premier League',
        status: 'completed',
        homeScore: 2,
        awayScore: 1,
      ),
      Fixture(
        id: 4,
        homeTeam: 'Dodoma Jiji',
        awayTeam: 'Azam FC',
        matchDate: DateTime.now().subtract(Duration(days: 14)),
        venue: 'Dodoma Stadium',
        tournament: 'Premier League',
        status: 'completed',
        homeScore: 0,
        awayScore: 3,
      ),
    ];
  }

  Map<String, List<Player>> _getMockSeniorPlayers() {
    return {
      'Goalkeepers': [
        Player(
          id: 1,
          name: 'Metacha Mnata',
          position: 'Goalkeeper',
          jerseyNumber: 1,
          dateOfBirth: DateTime(1995, 5, 15),
          nationality: 'Tanzania',
          image: 'assets/images/players/player1.jpg',
        ),
      ],
      'Defenders': [
        Player(
          id: 2,
          name: 'Dickson Job',
          position: 'Defender',
          jerseyNumber: 4,
          dateOfBirth: DateTime(1997, 8, 22),
          nationality: 'Tanzania',
          image: 'assets/images/players/player2.jpg',
        ),
      ],
      'Midfielders': [
        Player(
          id: 3,
          name: 'Prince Dube',
          position: 'Midfielder',
          jerseyNumber: 10,
          dateOfBirth: DateTime(1998, 3, 10),
          nationality: 'Zimbabwe',
          image: 'assets/images/players/player3.jpg',
        ),
      ],
      'Forwards': [
        Player(
          id: 4,
          name: 'Obrey Chirwa',
          position: 'Forward',
          jerseyNumber: 9,
          dateOfBirth: DateTime(1999, 7, 18),
          nationality: 'Malawi',
          image: 'assets/images/players/player4.jpg',
        ),
      ],
    };
  }

  List<Player> _getMockAllPlayers() {
    return [
      Player(
        id: 1,
        name: 'Metacha Mnata',
        position: 'Goalkeeper',
        jerseyNumber: 1,
        dateOfBirth: DateTime(1995, 5, 15),
        nationality: 'Tanzania',
        image: 'assets/images/players/player1.jpg',
      ),
      Player(
        id: 2,
        name: 'Dickson Job',
        position: 'Defender',
        jerseyNumber: 4,
        dateOfBirth: DateTime(1997, 8, 22),
        nationality: 'Tanzania',
        image: 'assets/images/players/player2.jpg',
      ),
      Player(
        id: 3,
        name: 'Prince Dube',
        position: 'Midfielder',
        jerseyNumber: 10,
        dateOfBirth: DateTime(1998, 3, 10),
        nationality: 'Zimbabwe',
        image: 'assets/images/players/player3.jpg',
      ),
    ];
  }

  // Mock data methods for shop
  List<Product> _getMockProducts() {
    return [
      Product(
        id: 1,
        name: 'Azam FC Home Jersey 2024',
        type: 'home',
        season: '2024',
        image: 'https://via.placeholder.com/300x300?text=Home+Jersey',
        customizationOptions: ['Name', 'Number'],
        price: 45000,
        isActive: true,
        inStock: true,
        description: 'Official Azam FC home jersey for the 2024 season.',
        createdAt: DateTime.now(),
        updatedAt: DateTime.now(),
      ),
      Product(
        id: 2,
        name: 'Azam FC Away Jersey 2024',
        type: 'away',
        season: '2024',
        image: 'https://via.placeholder.com/300x300?text=Away+Jersey',
        customizationOptions: ['Name', 'Number'],
        price: 45000,
        isActive: true,
        inStock: true,
        description: 'Official Azam FC away jersey for the 2024 season.',
        createdAt: DateTime.now(),
        updatedAt: DateTime.now(),
      ),
      Product(
        id: 3,
        name: 'Azam FC Training Kit',
        type: 'training',
        season: '2024',
        image: 'https://via.placeholder.com/300x300?text=Training+Kit',
        customizationOptions: [],
        price: 35000,
        isActive: true,
        inStock: false,
        description: 'Official Azam FC training kit.',
        createdAt: DateTime.now(),
        updatedAt: DateTime.now(),
      ),
    ];
  }

  List<Product> _getMockFeaturedProducts() {
    final allProducts = _getMockProducts();
    return allProducts.take(2).toList();
  }

  List<Product> _getMockProductsByCategory(String category) {
    final allProducts = _getMockProducts();
    return allProducts.where((product) => product.type == category).toList();
  }

  // Location API methods
  Future<Map<String, dynamic>> getRegions() async {
    try {
      final response = await _dio.get('/regions');
      return {
        'success': response.data['success'] ?? false,
        'data': response.data['data'] ?? [],
        'message': response.data['message'] ?? ''
      };
    } catch (e) {
      print('Error fetching regions: $e');
      return {
        'success': false,
        'data': [],
        'message': 'Failed to fetch regions: $e'
      };
    }
  }

  Future<Map<String, dynamic>> getDistricts(int regionId) async {
    try {
      final response = await _dio.get('/districts/$regionId');
      return {
        'success': response.data['success'] ?? false,
        'data': response.data['data'] ?? [],
        'message': response.data['message'] ?? ''
      };
    } catch (e) {
      print('Error fetching districts: $e');
      return {
        'success': false,
        'data': [],
        'message': 'Failed to fetch districts: $e'
      };
    }
  }

  // Fans API methods
  Future<FansResponse> getFans({
    int page = 1,
    int perPage = 20,
    String? search,
    String? region,
    String sortBy = 'points',
    String sortOrder = 'desc',
  }) async {
    try {
      final queryParams = {
        'page': page.toString(),
        'per_page': perPage.toString(),
        'sort_by': sortBy,
        'sort_order': sortOrder,
      };

      if (search != null && search.isNotEmpty) {
        queryParams['search'] = search;
      }

      if (region != null && region.isNotEmpty) {
        queryParams['region'] = region;
      }

      final response = await _dio.get('/fans', queryParameters: queryParams);
      
      if (response.data['success'] == true) {
        return FansResponse.fromJson(response.data);
      } else {
        throw Exception(response.data['message'] ?? 'Failed to fetch fans');
      }
    } catch (e) {
      print('Error fetching fans: $e');
      throw Exception('Failed to fetch fans: $e');
    }
  }

  // Exclusive Stories API methods (public - no authentication required)
  Future<List<ExclusiveStory>> getFeaturedExclusiveStories({int limit = 4}) async {
    try {
      final response = await _dio.get('/exclusive-stories/featured',
        queryParameters: {'limit': limit}
      );
      
      if (response.data['success'] == true) {
        final List<dynamic> storiesData = response.data['data'];
        return storiesData.map((json) => ExclusiveStory.fromJson(json)).toList();
      }
      return [];
    } catch (e) {
      print('Error fetching featured exclusive stories: $e');
      return _getMockExclusiveStories();
    }
  }

  Future<ExclusiveStoriesResponse> getExclusiveStories({int page = 1, int perPage = 10}) async {
    try {
      final response = await _dio.get('/exclusive-stories',
        queryParameters: {'page': page, 'per_page': perPage}
      );
      
      return ExclusiveStoriesResponse.fromJson(response.data);
    } catch (e) {
      print('Error fetching exclusive stories: $e');
      return ExclusiveStoriesResponse(
        success: false,
        stories: _getMockExclusiveStories(),
        error: e.toString(),
      );
    }
  }

  Future<ExclusiveStoriesResponse> getExclusiveStoriesByType(String type, {int page = 1, int perPage = 10}) async {
    try {
      final response = await _dio.get('/exclusive-stories/type/$type',
        queryParameters: {'page': page, 'per_page': perPage}
      );
      
      return ExclusiveStoriesResponse.fromJson(response.data);
    } catch (e) {
      print('Error fetching exclusive stories by type: $e');
      return ExclusiveStoriesResponse(
        success: false,
        stories: _getMockExclusiveStories().where((story) => story.type == type).toList(),
        error: e.toString(),
      );
    }
  }

  Future<ExclusiveStory?> getExclusiveStoryDetail(int storyId) async {
    try {
      final response = await _dio.get('/exclusive-stories/$storyId');
      
      if (response.data['success'] == true) {
        return ExclusiveStory.fromJson(response.data['data']);
      }
      return null;
    } catch (e) {
      print('Error fetching exclusive story detail: $e');
      return null;
    }
  }

  // Mock data for exclusive stories
  List<ExclusiveStory> _getMockExclusiveStories() {
    return [
      ExclusiveStory(
        id: 1,
        title: 'Last Training at Azam Complex Before Next Match',
        description: 'Behind the scenes photos from our final training session',
        type: 'photos',
        status: 'active',
        isFeatured: true,
        createdAt: DateTime.now().subtract(const Duration(hours: 2)),
        updatedAt: DateTime.now().subtract(const Duration(hours: 2)),
        mediaCount: 12,
        thumbnail: MediaThumbnail(
          url: 'https://via.placeholder.com/400x300?text=Training+Photos',
          type: 'image/jpeg',
        ),
      ),
      ExclusiveStory(
        id: 2,
        title: 'Prince Dube Signs New Contract & Speaks About Future',
        description: 'Exclusive interview with our star midfielder',
        type: 'videos',
        status: 'active',
        isFeatured: true,
        createdAt: DateTime.now().subtract(const Duration(days: 1)),
        updatedAt: DateTime.now().subtract(const Duration(days: 1)),
        mediaCount: 3,
        thumbnail: MediaThumbnail(
          url: 'https://via.placeholder.com/400x300?text=Prince+Dube+Interview',
          type: 'video/mp4',
        ),
      ),
      ExclusiveStory(
        id: 3,
        title: 'Behind the Scenes: Match Day Preparation',
        description: 'See how our team prepares for big matches',
        type: 'photos',
        status: 'active',
        isFeatured: false,
        createdAt: DateTime.now().subtract(const Duration(days: 3)),
        updatedAt: DateTime.now().subtract(const Duration(days: 3)),
        mediaCount: 8,
        thumbnail: MediaThumbnail(
          url: 'https://via.placeholder.com/400x300?text=Match+Preparation',
          type: 'image/jpeg',
        ),
      ),
    ];
  }
}
