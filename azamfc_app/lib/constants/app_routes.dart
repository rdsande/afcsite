import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';

import '../screens/splash/splash_screen.dart';
import '../screens/onboarding/onboarding_screen.dart';
import '../screens/auth/login_screen.dart';
import '../screens/auth/register_screen.dart';
import '../screens/main/main_screen.dart';
import '../screens/home/home_screen.dart';
import '../screens/news/news_screen.dart';
import '../screens/news/news_detail_screen.dart';
import '../screens/fixtures/fixtures_screen.dart';
import '../screens/fixtures/fixture_detail_screen.dart';
import '../screens/shop/shop_screen.dart';
import '../screens/account/account_screen.dart';
import '../screens/players/players_screen.dart';
import '../screens/players/player_detail_screen.dart';
import '../screens/search/search_screen.dart';

class AppRoutes {
  // Route names
  static const String splash = '/';
  static const String onboarding = '/onboarding';
  static const String login = '/login';
  static const String register = '/register';
  static const String main = '/main';
  static const String home = '/home';
  static const String news = '/news';
  static const String newsDetail = '/news-detail';
  static const String fixtures = '/fixtures';
  static const String fixtureDetail = '/fixture-detail';
  static const String shop = '/shop';
  static const String account = '/account';
  static const String players = '/players';
  static const String playerDetail = '/player-detail';
  static const String search = '/search';

  // Routes map
  static final Map<String, WidgetBuilder> routes = {
    splash: (context) => const SplashScreen(),
    onboarding: (context) => const OnboardingScreen(),
    login: (context) => const LoginScreen(),
    register: (context) => const RegisterScreen(),
    main: (context) => const MainScreen(),
    home: (context) => const HomeScreen(),
    news: (context) => const NewsScreen(),
    shop: (context) => const ShopScreen(),
    account: (context) => const AccountScreen(),
    players: (context) => const PlayersScreen(),
    search: (context) => const SearchScreen(),
  };

  // GoRouter configuration for complex routes
  static final GoRouter router = GoRouter(
    initialLocation: splash,
    routes: [
      GoRoute(
        path: splash,
        builder: (context, state) => const SplashScreen(),
      ),
      GoRoute(
        path: onboarding,
        builder: (context, state) => const OnboardingScreen(),
      ),
      GoRoute(
        path: login,
        builder: (context, state) => const LoginScreen(),
      ),
      GoRoute(
        path: register,
        builder: (context, state) => const RegisterScreen(),
      ),
      GoRoute(
        path: main,
        builder: (context, state) => const MainScreen(),
      ),
      GoRoute(
        path: newsDetail,
        builder: (context, state) {
          final newsId = state.pathParameters['id'];
          return NewsDetailScreen(newsId: newsId);
        },
      ),
      GoRoute(
        path: fixtureDetail,
        builder: (context, state) {
          final fixtureId = state.pathParameters['id'];
          return FixtureDetailScreen(fixtureId: fixtureId);
        },
      ),
      GoRoute(
        path: playerDetail,
        builder: (context, state) {
          final playerId = state.pathParameters['id'];
          return PlayerDetailScreen(playerId: playerId);
        },
      ),
    ],
  );

  // Custom route generator for complex routes
  static Route<dynamic>? onGenerateRoute(RouteSettings settings) {
    switch (settings.name) {
      case newsDetail:
        final args = settings.arguments as Map<String, dynamic>?;
        final newsId = args?['id'];
        return MaterialPageRoute(
          builder: (context) => NewsDetailScreen(newsId: newsId),
        );
      
      case fixtureDetail:
        final args = settings.arguments as Map<String, dynamic>?;
        final fixtureId = args?['id'];
        return MaterialPageRoute(
          builder: (context) => FixtureDetailScreen(fixtureId: fixtureId),
        );
      
      case playerDetail:
        final args = settings.arguments as Map<String, dynamic>?;
        final playerId = args?['id'];
        return MaterialPageRoute(
          builder: (context) => PlayerDetailScreen(playerId: playerId),
        );
      
      default:
        return null;
    }
  }

  // Navigation methods
  static void goToSplash(BuildContext context) => context.go(splash);
  static void goToOnboarding(BuildContext context) => context.go(onboarding);
  static void goToLogin(BuildContext context) => context.go(login);
  static void goToRegister(BuildContext context) => context.go(register);
  static void goToMain(BuildContext context) => context.go(main);
  static void goToHome(BuildContext context) => context.go(home);
  static void goToNews(BuildContext context) => context.go(news);
  static void goToShop(BuildContext context) => context.go(shop);
  static void goToAccount(BuildContext context) => context.go(account);
  static void goToPlayers(BuildContext context) => context.go(players);
  static void goToFixtures(BuildContext context) => context.go(fixtures);
  static void goToSearch(BuildContext context) => context.go(search);

  // Navigation with arguments
  static void goToNewsDetail(BuildContext context, String newsId) {
    context.go('$newsDetail?id=$newsId');
  }

  static void goToFixtureDetail(BuildContext context, String fixtureId) {
    context.go('$fixtureDetail?id=$fixtureId');
  }

  static void goToPlayerDetail(BuildContext context, String playerId) {
    context.go('$playerDetail?id=$playerId');
  }

  // Push routes (for back navigation)
  static void pushNewsDetail(BuildContext context, String newsId) {
    Navigator.pushNamed(context, newsDetail, arguments: {'id': newsId});
  }

  static void pushFixtureDetail(BuildContext context, String fixtureId) {
    Navigator.pushNamed(context, fixtureDetail, arguments: {'id': fixtureId});
  }

  static void pushPlayerDetail(BuildContext context, String playerId) {
    Navigator.pushNamed(context, playerDetail, arguments: {'id': playerId});
  }
}
