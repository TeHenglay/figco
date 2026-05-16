---
name: FigCo Core
colors:
  surface: '#f9f9ff'
  surface-dim: '#cfdaf2'
  surface-bright: '#f9f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f0f3ff'
  surface-container: '#e7eeff'
  surface-container-high: '#dee8ff'
  surface-container-highest: '#d8e3fb'
  on-surface: '#111c2d'
  on-surface-variant: '#424754'
  inverse-surface: '#263143'
  inverse-on-surface: '#ecf1ff'
  outline: '#727785'
  outline-variant: '#c2c6d6'
  surface-tint: '#005ac2'
  primary: '#0058be'
  on-primary: '#ffffff'
  primary-container: '#2170e4'
  on-primary-container: '#fefcff'
  inverse-primary: '#adc6ff'
  secondary: '#50616b'
  on-secondary: '#ffffff'
  secondary-container: '#d3e5f1'
  on-secondary-container: '#566771'
  tertiary: '#545d62'
  on-tertiary: '#ffffff'
  tertiary-container: '#6d767b'
  on-tertiary-container: '#fbfdff'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#d8e2ff'
  primary-fixed-dim: '#adc6ff'
  on-primary-fixed: '#001a42'
  on-primary-fixed-variant: '#004395'
  secondary-fixed: '#d3e5f1'
  secondary-fixed-dim: '#b7c9d5'
  on-secondary-fixed: '#0c1e26'
  on-secondary-fixed-variant: '#384953'
  tertiary-fixed: '#dbe4ea'
  tertiary-fixed-dim: '#bfc8ce'
  on-tertiary-fixed: '#141d21'
  on-tertiary-fixed-variant: '#3f484d'
  background: '#f9f9ff'
  on-background: '#111c2d'
  surface-variant: '#d8e3fb'
typography:
  headline-xl:
    fontFamily: Epilogue
    fontSize: 48px
    fontWeight: '800'
    lineHeight: '1.1'
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Epilogue
    fontSize: 32px
    fontWeight: '700'
    lineHeight: '1.2'
  headline-md:
    fontFamily: Epilogue
    fontSize: 24px
    fontWeight: '600'
    lineHeight: '1.3'
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: '1.6'
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: '1.5'
  technical-sm:
    fontFamily: Space Grotesk
    fontSize: 14px
    fontWeight: '500'
    lineHeight: '1.4'
    letterSpacing: 0.05em
  technical-xs:
    fontFamily: Space Grotesk
    fontSize: 12px
    fontWeight: '700'
    lineHeight: '1.2'
spacing:
  pixel-unit: 4px
  stack-sm: 8px
  stack-md: 16px
  stack-lg: 32px
  container-padding: 24px
  gutter: 20px
---

## Brand & Style

This design system establishes a visual identity for FigCo that rejects the sterile nature of modern B2B SaaS in favor of a "Sketch-Tech" aesthetic. The style is a deliberate hybrid of **Brutalism** and **Retro-Pixel** movements. It leverages the raw, intentional unrefinement of hand-drawn "doodles" to humanize the brand, while anchoring the interface in high-contrast 8-bit structures to maintain a sense of technical precision. 

The goal is to evoke a "living blueprint" feel—creative and approachable, yet mathematically sound. The interface should feel like a developer’s notebook: part logic, part imagination.

## Colors

The palette is anchored by high-clarity whites and atmospheric light blues to maintain the "SaaS" expectation of cleanliness, but it is disrupted by a heavy, structural dark slate.

- **Action Blue (#3B82F6):** Used exclusively for primary interactive elements, providing a clear focal point against the lighter backdrop.
- **Atmospheric Blue (#E0F2FE):** The primary container color, used to group related information without adding visual weight.
- **Ink Slate (#1E293B):** Used for all outlines, text, and 8-bit accents. This color replaces traditional grays to ensure the "doodle" ink feel is consistent.
- **Canvas White (#FFFFFF):** The base layer, providing maximum contrast for the hand-drawn elements.

## Typography

The typographic hierarchy utilizes three distinct families to manage the "doodle vs. tech" balance:

1.  **Headlines (Epilogue):** Chosen for its expressive, slightly geometric character that mimics the intentionality of a bold felt-tip marker. Use this for all major page headings and hero sections.
2.  **Body (Inter):** A neutral, highly readable sans-serif used for all long-form content and data entry to ensure the "doodle" aesthetic does not compromise B2B utility.
3.  **Technical Elements (Space Grotesk):** This font provides the 8-bit/futuristic vibe. It should be used for labels, button text, data points, and code snippets, reinforcing the mathematical nature of the platform.

## Layout & Spacing

The layout philosophy follows a **Fixed 8-Bit Grid**. All margins, paddings, and element heights must be multiples of 4px or 8px to maintain the "blocky" integrity of the 8-bit aesthetic.

- **Grid:** Use a 12-column fixed grid for desktop views with 20px gutters. 
- **The "Sticker" Offset:** Instead of standard padding, cards and containers should often feel "pasted" onto the background, utilizing consistent 16px or 32px stacks to create clear separation.
- **Alignment:** While borders may be "irregular" (see Shapes), the underlying content must strictly align to the grid to ensure professional SaaS usability.

## Elevation & Depth

In this design system, depth is achieved through **Structural Offsets** rather than light-source shadows. 

- **Hard Shadows:** Use a solid, non-blurred offset of 4px or 8px in Ink Slate (#1E293B) to lift elements. This creates a "sticker" or "pop-out" effect consistent with retro gaming.
- **Layering:** Surfaces do not use transparency. Depth is indicated by the thickness of the Ink Slate border (e.g., a 2px border for base elements, a 4px border for active modals).
- **Zero Blurs:** Do not use Gaussian blurs, drop shadows, or glassmorphism. Every edge must be crisp and definitive.

## Shapes

The shape language is the core of the hybrid aesthetic. It uses a **Sharp (0px)** base but applies decorative border masks.

- **The "Wobbly" Border:** Containers should use an SVG border mask that simulates a hand-drawn line—slightly thick in some areas and thinner in others, never perfectly straight.
- **The "Blocky" Corner:** For technical components (inputs, tags), use "stepped" corners that mimic low-resolution pixel art (a 4px x 4px notch cut out of corners).
- **Stroke Weight:** Maintain a consistent 2px stroke for standard elements and 4px for "hero" or "hovered" states.

## Components

- **Buttons:** Rectangular with a 2px solid border. On hover, the button should shift 4px down and 4px right, while a solid Slate "shadow" remains behind it, creating a tactile "click" feel. Text is always in Space Grotesk (Technical-XS).
- **Cards:** White or Light Blue backgrounds with the "Wobbly" hand-drawn border style. Use a solid 8px Slate offset shadow to denote interactivity.
- **Inputs:** Strictly rectangular with a blocky 8-bit corner. Use Space Grotesk for placeholder text. The focus state changes the border from Slate to Action Blue.
- **Chips/Tags:** Small, pixel-notched containers with a 1px border. Use high-contrast background colors from the secondary palette.
- **Icons:** Must be 24x24px, created using a limited "pixel-doodle" style—jagged lines that follow a grid but appear hand-sketched. No gradients or shadows within icons.
- **Progress Bars:** Designed to look like loading bars from an 8-bit OS, using solid blocks of color rather than smooth transitions.