import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:shared_preferences/shared_preferences.dart';

class ThemeProvider extends StateNotifier<ThemeMode> {
  ThemeProvider() : super(ThemeMode.system);

  Future<void> loadSavedTheme() async {
    final prefs = await SharedPreferences.getInstance();
    final themeString = prefs.getString('theme') ?? 'system';
    
    switch (themeString) {
      case 'light':
        state = ThemeMode.light;
        break;
      case 'dark':
        state = ThemeMode.dark;
        break;
      default:
        state = ThemeMode.system;
        break;
    }
  }

  Future<void> setTheme(ThemeMode themeMode) async {
    final prefs = await SharedPreferences.getInstance();
    String themeString;
    
    switch (themeMode) {
      case ThemeMode.light:
        themeString = 'light';
        break;
      case ThemeMode.dark:
        themeString = 'dark';
        break;
      default:
        themeString = 'system';
        break;
    }
    
    await prefs.setString('theme', themeString);
    state = themeMode;
  }

  void toggleTheme() {
    if (state == ThemeMode.light) {
      setTheme(ThemeMode.dark);
    } else {
      setTheme(ThemeMode.light);
    }
  }

  bool get isLight => state == ThemeMode.light;
  bool get isDark => state == ThemeMode.dark;
  bool get isSystem => state == ThemeMode.system;
}

final themeProviderProvider = StateNotifierProvider<ThemeProvider, ThemeMode>((ref) {
  return ThemeProvider();
});

// Blue Theme Provider
enum BlueTheme {
  lightBlue,
  darkBlue,
}

class BlueThemeProvider extends StateNotifier<BlueTheme> {
  BlueThemeProvider() : super(BlueTheme.lightBlue) {
    _loadBlueTheme();
  }

  static const String _blueThemeKey = 'blue_theme';

  Future<void> _loadBlueTheme() async {
    final prefs = await SharedPreferences.getInstance();
    final themeIndex = prefs.getInt(_blueThemeKey) ?? 0;
    state = BlueTheme.values[themeIndex];
  }

  Future<void> setBlueTheme(BlueTheme theme) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setInt(_blueThemeKey, theme.index);
    state = theme;
  }

  Future<void> toggleBlueTheme() async {
    final newTheme = state == BlueTheme.lightBlue 
        ? BlueTheme.darkBlue 
        : BlueTheme.lightBlue;
    await setBlueTheme(newTheme);
  }

  bool get isLightBlue => state == BlueTheme.lightBlue;
  bool get isDarkBlue => state == BlueTheme.darkBlue;
}

final blueThemeProvider = StateNotifierProvider<BlueThemeProvider, BlueTheme>(
  (ref) => BlueThemeProvider(),
);

// Blue theme colors
class BlueThemeColors {
  static const Color lightBlue = Color(0xFF2196F3);
  static const Color darkBlue = Color(0xFF1565C0);
  static const Color lightBlueShadow = Color(0x332196F3);
  static const Color darkBlueShadow = Color(0x331565C0);
  
  static Color getPrimaryColor(BlueTheme theme) {
    switch (theme) {
      case BlueTheme.lightBlue:
        return lightBlue;
      case BlueTheme.darkBlue:
        return darkBlue;
    }
  }
  
  static Color getShadowColor(BlueTheme theme) {
    switch (theme) {
      case BlueTheme.lightBlue:
        return lightBlueShadow;
      case BlueTheme.darkBlue:
        return darkBlueShadow;
    }
  }
  
  static List<BoxShadow> getCreativeShadows(BlueTheme theme) {
    final primaryColor = getPrimaryColor(theme);
    return [
      BoxShadow(
        color: primaryColor.withOpacity(0.3),
        blurRadius: 20,
        offset: const Offset(0, 8),
        spreadRadius: 0,
      ),
      BoxShadow(
        color: primaryColor.withOpacity(0.1),
        blurRadius: 40,
        offset: const Offset(0, 16),
        spreadRadius: 0,
      ),
    ];
  }
}
