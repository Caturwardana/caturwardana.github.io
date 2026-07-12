# Portfolio Website - Catur Wardana

> Mechanical Design & Analysis Engineer Portfolio

Live Site: [caturwardana.github.io](https://caturwardana.github.io)

---

## About

Personal portfolio website showcasing engineering projects, professional experience, and technical skills in mechanical design, structural analysis, CAD/CAE, rapid prototyping, UAV & robotics engineering.

## Features

- **Hero Section** - Animated typing effect with particle.js background
- **About Me** - Profile overview with resume download link
- **Skills & Abilities** - Interactive skill bars with icons (SolidWorks, AutoCAD, Ansys, etc.)
- **Education** - Academic background (UGM, SMK 2 Yogyakarta)
- **Projects** - Filterable project gallery with detail pages
- **Experience** - Timeline of professional experience
- **Contact** - Formspree-powered contact form

## Project Detail Page

Each project has a dedicated detail page (`project-detail.html?id={slug}`) featuring:
- Full description and specifications
- Project poster (if available)
- Embedded YouTube videos
- News & media coverage links
- Research resources (journals, patents, documentation)
- Image gallery with lightbox viewer
- Certificate/document links (HKI, PIMNAS, etc.)

## Tech Stack

- HTML5, CSS3, JavaScript (ES6+)
- jQuery 3.6
- Particle.js (background animation)
- Typed.js (typing effect)
- Vanilla Tilt.js (3D tilt effect)
- ScrollReveal (scroll animations)
- Isotope (project filtering)
- Formspree (contact form)
- Font Awesome 5 (icons)

## File Structure

```
caturwardana.github.io/
├── index.html                    # Main page
├── 404.html                      # Custom 404 page
├── skills.json                   # Skills data
├── assets/
│   ├── css/style.css             # Main stylesheet
│   ├── js/
│   │   ├── script.js             # Main JavaScript
│   │   ├── particles.min.js      # Particle.js library
│   │   └── app.js                # Particle.js config
│   └── images/
│       ├── favicon.png           # Site favicon
│       ├── hero.png              # Hero illustration
│       ├── profile2.jpg          # Profile photo
│       ├── educat/               # Education images
│       └── projects/             # Project images & documents
│           ├── batik-dryer/
│           ├── smart-leveling/
│           ├── IB-GUN/
│           ├── ev3-evo/
│           ├── et-1/
│           ├── kandang-ventilasi/
│           ├── kandang-filter/
│           ├── dosing-irigasi/
│           ├── wound-scanner/
│           └── hydroponic-tea/
├── experience/
│   ├── index.html                # Experience detail page
│   ├── style.css                 # Experience page styles
│   └── script.js                 # Experience page scripts
└── projects/
    ├── index.html                # Projects listing page
    ├── project-detail.html       # Dynamic project detail page
    ├── project-detail.css        # Detail page styles
    ├── project-detail.js         # Detail page logic
    ├── projects.json             # All projects data
    ├── script.js                 # Projects page scripts
    └── style.css                 # Projects page styles
```

## Projects Included

| Project | Category | Date |
|---------|----------|------|
| Digital Artificial Insemination Gun (IB-G2) | Mechanical | Feb 2022 - Nov 2022 |
| Super Sekip EV-3 EVO | Automotive | Dec 2021 - May 2022 |
| Yacaranda ET-1 | Automotive | Oct 2020 - Nov 2021 |
| Alat Pengering Batik (Batik Dryer) | Mechanical | Feb 2021 - Sep 2021 |
| Smart Leveling | Robotics | Feb 2021 - Sep 2021 |
| Kandang Hewan Percobaan - IVC Cage | Mechanical | Sep 2023 - Mar 2024 |
| Kandang Hewan - IVC Rack System | Mechanical | Sep 2023 - Feb 2024 |
| Mesin Dosing dan Irigasi Otomatis | Automation | Dec 2023 - Feb 2024 |
| Pemindai Dimensi Luka Portabel | Medical | Jul 2023 - Dec 2023 |
| Hydroponic Tea Seeds with IoT | Automation | Dec 2021 - Feb 2022 |

## How to Add a New Project

### 1. Add Images

Create a folder in `assets/images/projects/{slug}/`:

```
assets/images/projects/my-new-project/
├── thumb.jpg          # Thumbnail image
├── poster.jpg         # Poster (optional)
├── 1.jpg              # Gallery images
├── 2.jpg
└── tambahan.txt       # Additional notes
```

### 2. Add Entry in `projects/projects.json`

```json
{
    "id": "my-new-project",
    "name": "My New Project",
    "category": "mechanical",
    "date": "Jan 2024 - Jun 2024",
    "client": "Company Name",
    "thumbnail": "my-new-project/thumb.jpg",
    "shortDesc": "Brief one-line description.",
    "fullDesc": "Full detailed description of the project...",
    "poster": "my-new-project/poster.jpg",
    "specs": [
        "Specification 1",
        "Specification 2"
    ],
    "skills": ["CAD", "SolidWorks", "Analysis"],
    "images": [
        "my-new-project/thumb.jpg",
        "my-new-project/1.jpg",
        "my-new-project/2.jpg"
    ],
    "videos": [
        {
            "title": "Video Title",
            "url": "https://youtu.be/xxxxx"
        }
    ],
    "news": [
        {
            "title": "News Title - Source",
            "url": "https://news-site.com/article"
        }
    ],
    "resources": [
        {
            "title": "Resource Title",
            "url": "https://link-or-local-path",
            "type": "journal"
        }
    ],
    "achievements": "Achievement description (optional)"
}
```

### 3. Resource Types

| Type | Icon | Use For |
|------|------|---------|
| `journal` | 📖 | Research papers, Journals |
| `patent` | 📜 | HKI, Patents, Certificates |
| `documentation` | 📄 | Technical docs, Reports |
| `report` | 📊 | Lab reports, Analysis |
| `github` | 💻 | Source code repos |
| `website` | 🌐 | External links |
| `other` | 🔗 | Anything else |

### 4. Image Naming Convention

Rename images to sequential numbers: `1.jpg`, `2.jpg`, `3.jpg`, etc.
Keep `thumb.jpg` as the first/main image.

## How to Add Skills

Edit `skills.json`:

```json
{
    "name": "Skill Name",
    "icon": "https://img.icons8.com/fluency/48/icon-name.png"
}
```

## Local Development

1. Clone the repo:
   ```bash
   git clone https://github.com/Caturwardana/caturwardana.github.io.git
   ```

2. Open with a local server (e.g., Live Server in VS Code):
   ```bash
   # Using Python
   python -m http.server 8000

   # Using Node.js
   npx serve .
   ```

3. Open `http://localhost:8000` in browser.

## Contact

- **LinkedIn**: [linkedin.com/in/caturwardana](https://www.linkedin.com/in/caturwardana)
- **GitHub**: [github.com/Caturwardana](https://github.com/Caturwardana)
- **Location**: Bantul, Yogyakarta (55751)

## License

This portfolio is for personal use. Design template by [LifeCodes](https://github.com/life-code).

## Credits

Special thanks to [Jigar Sable](https://github.com/jigar-sable) for the original [Portfolio-Website](https://github.com/jigar-sable/Portfolio-Website) template. 

The template has been significantly modified to support:
- **Project detail pages** with dynamic data loading from JSON, YouTube video embeds, image gallery with lightbox, news/media links, and research resources
- **Custom styling** and content tailored for a Mechanical Design & Analysis Engineer portfolio
- **Additional pages** including projects listing, project detail, and experience detail pages
