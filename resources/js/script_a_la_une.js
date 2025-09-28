document.addEventListener('DOMContentLoaded', function () {
  function updateTimeAgo() {
    document.querySelectorAll('.time-ago').forEach(function(el) {
      const timestamp = parseInt(el.dataset.timestamp) * 1000; // en ms
      const diff = Date.now() - timestamp;
      const minutes = Math.floor(diff / (1000 * 60));
      const hours = Math.floor(diff / (1000 * 60 * 60));
      const days = Math.floor(diff / (1000 * 60 * 60 * 24));

      if (minutes < 1) el.textContent = 'À l’instant';
      else if (minutes < 60) el.textContent = `Il y a ${minutes} min`;
      else if (hours < 24) el.textContent = `Il y a ${hours} h`;
      else el.textContent = `Il y a ${days} j`;
    });
  }

  updateTimeAgo();
  setInterval(updateTimeAgo, 60000); // mise à jour chaque minute
});