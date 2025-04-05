document.addEventListener('DOMContentLoaded', function() {
    // Search Templates
    const searchInput = document.querySelector('input[placeholder="Search templates..."]');
    if (searchInput) {
        searchInput.addEventListener('input', debounce(function(e) {
            const query = e.target.value;
            if (query.length > 2) {
                fetch('/viral-content/search', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ query })
                })
                .then(response => response.json())
                .then(data => {
                    updateTemplatesGrid(data);
                })
                .catch(error => console.error('Error:', error));
            }
        }, 300));
    }

    // Generate Content Ideas
    const generateButton = document.querySelector('button[data-topic-id]');
    if (generateButton) {
        generateButton.addEventListener('click', function() {
            const topicId = this.dataset.topicId;
            const platform = this.dataset.platform;
            
            fetch('/viral-content/generate-ideas', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ topic_id: topicId, platform })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateContentIdeas(data.ideas);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }

    // Analytics Period Selector
    const periodSelector = document.querySelector('select');
    if (periodSelector) {
        periodSelector.addEventListener('change', function() {
            const period = this.value;
            
            updateAnalytics(period);
        });
    }

    // Helper Functions
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    function updateTemplatesGrid(templates) {
        const grid = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3');
        if (grid) {
            grid.innerHTML = templates.map(template => `
                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">${template.title}</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                ${template.category}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mb-4">${template.description}</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                ${template.estimated_time} min
                            </div>
                            <a href="/viral-content/${template.id}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Use Template
                            </a>
                        </div>
                    </div>
                </div>
            `).join('');
        }
    }

    function updateContentIdeas(ideas) {
        const grid = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2');
        if (grid) {
            grid.innerHTML = ideas.map(idea => `
                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">${idea.title}</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                ${idea.platform}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mb-4">${idea.description}</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                ${idea.viral_potential}% viral potential
                            </div>
                            <a href="/post-generator?idea=${idea.id}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Use Idea
                            </a>
                        </div>
                    </div>
                </div>
            `).join('');
        }
    }

    function updateAnalytics(period) {
        fetch(`/viral-content/analytics?period=${period}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            updateAnalyticsDisplay(data);
        })
        .catch(error => console.error('Error:', error));
    }

    function updateAnalyticsDisplay(analytics) {
        document.querySelector('[data-analytics="total_views"]').textContent = analytics.total_views;
        document.querySelector('[data-analytics="views_change"]').textContent = analytics.views_change;
        document.querySelector('[data-analytics="engagement_rate"]').textContent = analytics.engagement_rate;
        document.querySelector('[data-analytics="engagement_change"]').textContent = analytics.engagement_change;
        document.querySelector('[data-analytics="top_topic"]').textContent = analytics.top_topic;
        document.querySelector('[data-analytics="top_topic_views"]').textContent = analytics.top_topic_views;
        document.querySelector('[data-analytics="avg_time"]').textContent = analytics.avg_time;
        document.querySelector('[data-analytics="time_change"]').textContent = analytics.time_change;
    }
}); 