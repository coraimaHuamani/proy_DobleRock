        document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.music-tab');
        const sections = {
        albums: document.getElementById('albums'),
        songs: document.getElementById('songs'),
        recent: document.getElementById('recent'),
        popular: document.getElementById('popular')
        };

        tabs.forEach(tab => {
        tab.addEventListener('click', function() {
        tabs.forEach(t => t.classList.remove('text-orange-500', 'border-b-2',
        'border-orange-500'));
        tab.classList.add('text-orange-500', 'border-b-2', 'border-orange-500');
        Object.values(sections).forEach(sec => sec.classList.add('hidden'));
        const tabName = tab.getAttribute('data-tab');
        if (sections[tabName]) {
        sections[tabName].classList.remove('hidden');
        }
        });
        });
        });
