class PhoneFormatter {
  /// Formats a Tanzanian phone number to the standard format expected by the backend
  /// Handles inputs like:
  /// - +255712345678 -> 0712345678
  /// - 255712345678 -> 0712345678
  /// - 0712345678 -> 0712345678
  /// - 712345678 -> 0712345678
  static String formatTanzanianPhone(String phone) {
    // Remove all spaces and special characters except +
    String cleaned = phone.replaceAll(RegExp(r'[\s\-\(\)]'), '');
    
    // Handle different formats
    if (cleaned.startsWith('+255')) {
      // +255712345678 -> 0712345678
      String withoutCountryCode = cleaned.substring(4);
      return '0$withoutCountryCode';
    } else if (cleaned.startsWith('255')) {
      // 255712345678 -> 0712345678
      String withoutCountryCode = cleaned.substring(3);
      return '0$withoutCountryCode';
    } else if (cleaned.startsWith('0')) {
      // 0712345678 -> 0712345678 (already correct)
      return cleaned;
    } else if (cleaned.length == 9 && cleaned.startsWith('7')) {
      // 712345678 -> 0712345678
      return '0$cleaned';
    }
    
    // Return as-is if format is not recognized
    return cleaned;
  }
  
  /// Validates if a phone number is a valid Tanzanian mobile number
  /// Valid formats: 071xxxxxxx, 072xxxxxxx, 073xxxxxxx, 074xxxxxxx, 075xxxxxxx, 076xxxxxxx, 077xxxxxxx, 078xxxxxxx, 079xxxxxxx
  static bool isValidTanzanianPhone(String phone) {
    String formatted = formatTanzanianPhone(phone);
    
    // Check if it matches Tanzanian mobile number pattern
    RegExp tanzanianMobilePattern = RegExp(r'^07[1-9]\d{7}$');
    return tanzanianMobilePattern.hasMatch(formatted);
  }
  
  /// Formats phone number for display with +255 prefix
  /// 0712345678 -> +255 712 345 678
  static String formatForDisplay(String phone) {
    String formatted = formatTanzanianPhone(phone);
    if (formatted.startsWith('0') && formatted.length == 10) {
      String withoutZero = formatted.substring(1);
      return '+255 ${withoutZero.substring(0, 3)} ${withoutZero.substring(3, 6)} ${withoutZero.substring(6)}';
    }
    return phone;
  }
}