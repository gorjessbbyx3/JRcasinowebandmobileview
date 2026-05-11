# Cashout Casino - VanguardLTE Platform

### Overview
The Cashout Casino project is a VanguardLTE casino platform built on PHP/Laravel, using PostgreSQL. Its main purpose is to provide a comprehensive online casino experience with a focus on rich visual design, engaging bonus systems, and a streamlined user interface. The platform aims to deliver a premium gaming environment, featuring advanced bonus mechanics, interactive game carousels, and a robust backend for administrative control. Key ambitions include offering a highly customizable and visually appealing casino experience that stands out in the online gaming market.

### User Preferences
I want the agent to prioritize developing premium visual designs and interactive UI elements. Focus on modern aesthetics, smooth animations, and responsive layouts across all features. When implementing new features or redesigns, ensure they align with a "premium casino" feel, utilizing effects like glass morphism, neon glows, and gradient accents. I prefer detailed explanations of the design choices and technical implementations, especially concerning animations and responsive behaviors. Ensure that any changes maintain accessibility standards, particularly for mobile touch targets.

### System Architecture
The platform is built on PHP 8.2 with Laravel 11.x, utilizing PostgreSQL as its primary database. The core application resides in the `casino/` directory, supported by `frontend/` assets, a `back/` administrative panel, and `woocasino/` for additional modules and theme customizations.

**UI/UX Decisions & Design Patterns:**
- **Premium Visual Redesign:** The UI/UX emphasizes a high-quality, modern casino aesthetic. This includes:
    - **Bonus Page:** Premium cards with gradient headers, hover effects, SVG animations (Wheel of Fortune), live-updating jackpots, and daily login streak displays.
    - **Jade Royale Theme:** A dark theme with a black header and sidebar, prominent dragon logo, redesigned gradient-styled login modal, and rounded, green-accented sidebar menu cards.
    - **Minimal Layout:** Hides the traditional header and sidebar for a clean, fullscreen game view, replaced by a floating logo and an action bar below the slideshow.
    - **Premium Mobile Design:** Incorporates glass morphism, neon glow effects (e.g., login button), gradient glass bonus icons, and premium typography (Poppins font). All interactive mobile elements maintain a minimum 48px height for accessibility.
    - **Netflix-Style Game Carousels:** Features premium category headers with neon glows, multi-row game carousels (Slots, Fish & Arcade, Table Games) with hover effects, touch swipe support, and arrow navigation. Game categorization is based on keyword matching.
    - **Bonus Modal Popup:** Consolidates all bonus features into a single tabbed modal with glass morphism styling, interactive elements (Wheel, Jackpots, Daily, Welcome), and responsive design.
    - **Dragon Egg Daily Bonus & MORE Modal:** Introduces an interactive Dragon Egg game for daily rewards and a "MORE" modal for consolidated account management (History, Settings, Profile, Message).
    - **Player Action Bar:** A dedicated bar below bonus icons featuring a game search, distinct deposit/withdraw buttons, and a dynamic balance display.
    - **Premium Fortune Wheel:** A completely redesigned, visually rich wheel with cosmic background, golden ornate frame, blinking lights, and celebratory animations.
- **Technical Implementations:**
    - Uses Laravel Blade templates for frontend rendering.
    - Settings are managed via the `anlutro/l4-settings` package, stored in the `w_settings` table.
    - Extensive CSS (e.g., `bonuses.css`, `jade-royale-ui.css`, `minimal-layout.css`, `netflix-carousel.css`) for custom styling and animations.
    - JavaScript is used for interactive elements like the Wheel of Fortune, game carousels, and modal functionalities.
- **Feature Specifications:**
    - **Bonus Management:** Welcome Bonuses, Happy Hour, Loyalty/SMS Bonuses, Wheel of Fortune, Progressive Jackpots, Daily Login Rewards, and Achievements are all implemented and manageable via the backend admin panel.
    - **Registration Policy:** Frontend registration is disabled; player accounts are created via the backend by cashiers.
    - **Site Footer:** Includes casino logo, Facebook social link, and copyright information.
    - **Mobile Responsiveness:** All redesigned pages and features are optimized for various mobile breakpoints, ensuring a consistent user experience across devices.

### External Dependencies
- **Database:** PostgreSQL (configured via `DATABASE_URL`)
- **PHP Framework:** Laravel (11.x)
- **PHP Package:** `anlutro/l4-settings` (for settings management)
- **Social Integration:** Facebook (linked in footer)