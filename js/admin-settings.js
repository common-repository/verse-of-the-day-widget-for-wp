function votdcopyShortcode(e) {
  e.preventDefault()
  let shortcodeInput = document.getElementById("votd_shortcode");
  shortcodeInput.select();
  shortcodeInput.setSelectionRange(0, 99999); // For mobile devices

  // Copy the text inside the text field
  document.execCommand("copy");

  // Optionally, you can alert the user that the shortcode has been copied
  alert("Shortcode copied: " + shortcodeInput.value);
}