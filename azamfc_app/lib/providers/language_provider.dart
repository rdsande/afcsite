import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:shared_preferences/shared_preferences.dart';

class LanguageProvider extends StateNotifier<Locale> {
  LanguageProvider() : super(const Locale('sw', 'TZ'));

  Future<void> loadSavedLanguage() async {
    final prefs = await SharedPreferences.getInstance();
    final languageCode = prefs.getString('language') ?? 'sw';
    state = Locale(languageCode, languageCode == 'sw' ? 'TZ' : 'US');
  }

  Future<void> setLanguage(String languageCode) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString('language', languageCode);
    state = Locale(languageCode, languageCode == 'sw' ? 'TZ' : 'US');
  }

  void toggleLanguage() {
    final newLanguage = state.languageCode == 'sw' ? 'en' : 'sw';
    setLanguage(newLanguage);
  }

  bool get isEnglish => state.languageCode == 'en';
  bool get isSwahili => state.languageCode == 'sw';
}

final languageProviderProvider = StateNotifierProvider<LanguageProvider, Locale>((ref) {
  return LanguageProvider();
});
