---
name: Kinetic Glass Tech
colors:
  surface: '#f7fafc'
  surface-dim: '#d7dadc'
  surface-bright: '#f7fafc'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f1f4f6'
  surface-container: '#ebeef0'
  surface-container-high: '#e5e9eb'
  surface-container-highest: '#e0e3e5'
  on-surface: '#181c1e'
  on-surface-variant: '#43474e'
  inverse-surface: '#2d3133'
  inverse-on-surface: '#eef1f3'
  outline: '#74777f'
  outline-variant: '#c4c6cf'
  surface-tint: '#455f88'
  primary: '#002045'
  on-primary: '#ffffff'
  primary-container: '#1a365d'
  on-primary-container: '#86a0cd'
  inverse-primary: '#adc7f7'
  secondary: '#006d3c'
  on-secondary: '#ffffff'
  secondary-container: '#85f6ad'
  on-secondary-container: '#00723f'
  tertiary: '#371800'
  on-tertiary: '#ffffff'
  tertiary-container: '#572900'
  on-tertiary-container: '#e88532'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#d6e3ff'
  primary-fixed-dim: '#adc7f7'
  on-primary-fixed: '#001b3c'
  on-primary-fixed-variant: '#2d476f'
  secondary-fixed: '#88f9b0'
  secondary-fixed-dim: '#6bdc96'
  on-secondary-fixed: '#00210f'
  on-secondary-fixed-variant: '#00522c'
  tertiary-fixed: '#ffdcc5'
  tertiary-fixed-dim: '#ffb783'
  on-tertiary-fixed: '#301400'
  on-tertiary-fixed-variant: '#703700'
  background: '#f7fafc'
  on-background: '#181c1e'
  surface-variant: '#e0e3e5'
  deep-navy: '#1A365D'
  vibrant-green: '#48BB78'
  energetic-orange: '#ED8936'
  glass-surface: rgba(255, 255, 255, 0.7)
  glass-border: rgba(255, 255, 255, 0.4)
typography:
  display-lg:
    fontFamily: Montserrat
    fontSize: 64px
    fontWeight: '700'
    lineHeight: '1.1'
    letterSpacing: -0.02em
  display-lg-mobile:
    fontFamily: Montserrat
    fontSize: 40px
    fontWeight: '700'
    lineHeight: '1.2'
  headline-md:
    fontFamily: Montserrat
    fontSize: 32px
    fontWeight: '700'
    lineHeight: '1.3'
  headline-sm:
    fontFamily: Montserrat
    fontSize: 24px
    fontWeight: '600'
    lineHeight: '1.4'
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: '1.6'
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: '1.6'
  label-bold:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '700'
    lineHeight: '1.2'
    letterSpacing: 0.05em
  label-sm:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '500'
    lineHeight: '1.2'
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  container-max: 1280px
  gutter: 24px
  margin-mobile: 20px
  section-gap: 120px
  stack-sm: 8px
  stack-md: 16px
  stack-lg: 32px
---

## Brand & Style

This design system embodies the spirit of a premium, modern coding school where logic meets creative play. The brand personality is educational, innovative, and inspiring, designed to appeal to both ambitious students and tech-forward parents. 

The visual style is a sophisticated blend of **Glassmorphism** and **Corporate Modern**. It uses semi-transparent surfaces and blurred backdrops to create a sense of depth and technical precision, while maintaining the structural reliability of an academic institution. The UI is characterized by vibrant gradients, generous whitespace, and high-energy accents that bridge the gap between abstract code and real-world impact.

## Colors

The palette is rooted in a professional **Deep Navy**, providing a stable foundation for the high-energy **Vibrant Green** and **Energetic Orange** accents. 

- **Primary (Navy):** Used for core branding, headlines, and primary button backgrounds to instill trust.
- **Secondary (Green):** Representing growth and "go" states; used for success indicators, primary action gradients, and feature highlights.
- **Tertiary (Orange):** Evoking energy and creativity; used for specific CTAs, notifications, and playful UI elements.
- **Surface Strategy:** The background uses a very light neutral cool grey. Interactive cards utilize a semi-transparent white (Glass Surface) with a thin, bright border to create the glassmorphic effect over colored background glows.

## Typography

This design system uses a dual-font approach to balance impact with utility. 

**Montserrat** is used for all headlines and display text. Its geometric construction feels modern and architectural, mirroring the structure of code. For body text and functional labels, **Inter** provides exceptional legibility and a neutral, tech-forward aesthetic.

Large display headings should utilize tight letter-spacing to feel "locked-in" and impactful. Body text uses a generous line-height to ensure long-form educational content remains approachable and easy to digest.

## Layout & Spacing

The layout philosophy follows a **fixed grid** model for desktop, centered within a maximum width of 1280px. It utilizes a 12-column grid to allow for flexible content arrangements (e.g., 50/50 hero splits or 4-column feature grids).

- **Vertical Rhythm:** A heavy emphasis is placed on "breathing room." Section gaps are generous (120px) to prevent cognitive overload.
- **Mobile Adaptation:** On mobile, the grid collapses to a single column with 20px side margins. Section gaps scale down to 60px.
- **Consistency:** All spacing between elements within a component must be a multiple of 8px to maintain a mathematical, technical rhythm.

## Elevation & Depth

Hierarchy is established through **Glassmorphism** and **Ambient Shadows**.

1.  **The Base:** Flat, neutral background.
2.  **The Glow:** Large, soft radial gradients in primary/secondary colors sit behind key content areas to suggest light sources.
3.  **The Glass Layer:** Cards use a `backdrop-filter: blur(12px)` with a semi-transparent white fill.
4.  **Shadow Character:** Shadows are rarely used on flat surfaces. Instead, they are reserved for the "Lifted" state. They are extra-diffused (20-40px blur), low-opacity (10%), and slightly tinted with the Primary Navy color to ensure they feel integrated rather than "dirty."

## Shapes

The shape language is friendly and modern, utilizing **Rounded** corners to soften the "hard" edge of technology. 

Standard components like input fields and small cards use a 0.5rem (8px) radius. Larger container elements and glassmorphic cards use a 1rem (16px) or 1.5rem (24px) radius to emphasize the "soft tech" feel. Interactive elements like pill-buttons utilize full rounding for a tactile, playful appearance.

## Components

### Buttons
- **Primary:** Navy Blue background or a Navy-to-Green gradient. Full pill shape.
- **Secondary:** Ghost style with a 2px Navy border or Glassmorphic surface.
- **Interactivity:** On hover, buttons should `scale(1.05)` and increase shadow spread.

### Glass Cards
Used for "Key Values" and "Program" modules. Features a 1px border (`rgba(255,255,255,0.4)`), a soft backdrop blur, and internal padding of 32px.

### Chips & Tags
Small, highly rounded (pill) tags. Use energetic Orange for "New" or "Latest" info to draw immediate attention.

### Input Fields
Soft white backgrounds with a 1px Navy border that transitions to a Vibrant Green glow on focus.

### Interactive Transforms
All cards should have a subtle "lift" effect on hover: a combination of `translateY(-8px)` and an increased ambient shadow to make the school's digital presence feel reactive and alive.