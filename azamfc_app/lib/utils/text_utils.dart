class TextUtils {
  /// Strips HTML tags from a string and returns plain text
  static String stripHtmlTags(String htmlString) {
    if (htmlString.isEmpty) return htmlString;
    
    // Remove HTML tags using RegExp
    final RegExp htmlTagRegExp = RegExp(r'<[^>]*>');
    String plainText = htmlString.replaceAll(htmlTagRegExp, '');
    
    // Decode common HTML entities
    plainText = plainText
        .replaceAll('&amp;', '&')
        .replaceAll('&lt;', '<')
        .replaceAll('&gt;', '>')
        .replaceAll('&quot;', '"')
        .replaceAll('&#39;', "'")
        .replaceAll('&nbsp;', ' ');
    
    // Clean up extra whitespace
    plainText = plainText.replaceAll(RegExp(r'\s+'), ' ').trim();
    
    return plainText;
  }
  
  /// Creates an excerpt from content with specified length
  static String createExcerpt(String content, {int maxLength = 150}) {
    final plainText = stripHtmlTags(content);
    if (plainText.length <= maxLength) return plainText;
    
    // Find the last space before maxLength to avoid cutting words
    int cutIndex = maxLength;
    for (int i = maxLength; i >= 0; i--) {
      if (plainText[i] == ' ') {
        cutIndex = i;
        break;
      }
    }
    
    return '${plainText.substring(0, cutIndex)}...';
  }
}