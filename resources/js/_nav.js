export default {
  items: [
    {
      name: 'Dashboard',
      url: '/admin/dashboard',
      icon: 'fas fa-chart-bar',
    },
    {
      divider: true
    },
    {
      name: 'News',
      url: '/admin/news',
      icon: 'fas fa-newspaper',
      children: [
        {
          name: 'Posts',
          url: '/admin/news',
          icon: 'fas fa-newspaper',
        },
        {
          name: 'Post Categories',
          url: '/admin/news/post-categories',
          icon: 'fas fa-list'
        },
      ]
    },
    {
      name: 'Best Location',
      url: '/admin/locations',
      icon: 'fas fa-map-marker-alt',
      children: [
        {
          name: 'Locations',
          url: '/admin/locations',
          icon: 'fas fa-map-marker-alt',
        },
        {
          name: 'Location Categories',
          url: '/admin/locations/location-categories',
          icon: 'fas fa-list'
        },
      ]
    },
    {
      name: 'Events',
      url: '/admin/events',
      icon: 'fas fa-calendar',
    },
    {
      name: 'Complaints',
      url: '/admin/complaints',
      icon: 'fas fa-list',
      children: [
        {
          name: 'Complaint List',
          url: '/admin/complaints',
          icon: 'fas fa-list',
        },
        {
          name: 'Complaint Categories',
          url: '/admin/complaints/complaint-categories',
          icon: 'fas fa-list'
        },
      ]
    },
    {
      name: 'Gallery',
      url: '/admin/gallery',
      icon: 'fas fa-image'
    },
    {
      name: 'Users',
      url: '/admin/users',
      icon: 'fas fa-user',
    }
  ]
}