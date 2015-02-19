// Saves options to chrome.storage.sync.
function save_options() {
  var savecentral = document.getElementById('urlinput').value;
  var code = document.getElementById('code').value;
  var path = document.getElementById('path').value;
  chrome.storage.sync.set({
    savecentral: savecentral,
    code: code,
    path: path
  }, function() {
    // Update status to let user know options were saved.
    var status = document.getElementById('status');
    status.textContent = 'Options saved.';
    setTimeout(function() {
      status.textContent = '';
    }, 750);
  });
}

// Restores select box and checkbox state using the preferences
// stored in chrome.storage.
function restore_options() {
  // Use default value color = 'red' and likesColor = true.
  chrome.storage.sync.get({
    savecentral: "savecentral",
    code: "code",
    path: "path"
  }, function(items) {
    document.getElementById('urlinput').value = items.savecentral;
    document.getElementById('code').value = items.code;
  });
}

document.addEventListener('DOMContentLoaded', restore_options);
document.getElementById('save').addEventListener('click', save_options);