# Ahm Akram WordPress Theme

## Install
Zip the `ahm-akram` folder and upload it in **Appearance → Themes**. Activate it, then set a static front page if desired.

## Configure
Open **Settings → Ahm Akram** to edit the role, headline, proof values, social links, booking URL, WhatsApp, email, accent color, seed, placeholder count and featured-order behavior.

## Content
Create **Case Studies** for featured and archive content. Native meta fields include `_ahm_client`, `_ahm_industry`, `_ahm_services`, `_ahm_channels`, `_ahm_headline_kpi`, `_ahm_kpi_list`, `_ahm_challenge`, `_ahm_strategy`, `_ahm_what_i_did`, `_ahm_results`, `_ahm_tools`, `_ahm_quote`, `_ahm_quote_author`, `_ahm_quote_company`, `_ahm_year`, `_ahm_featured`, `_ahm_manual_order`, `_ahm_linked_case`, and `_ahm_before_after`.

Use only verified client names and metrics. Add `1` to `_ahm_featured` for the Results panel. The supplied totals are defaults: 5+ years, $50,000+ ad spend, 126 million impressions, 45 million+ clicks, 1 million leads, 80,000+ sales, $164,389 revenue and ~3.3x ROAS. The footnote reads 2020–the current year.

## Placeholder and testimonial policy
Testimonial cards and placeholder portfolio copy are visibly marked and must be replaced. Never publish invented clients or campaign results.

## Contact
Set **Contact email** and configure SMTP. The REST form at `/wp-json/ahm-akram/v1/contact` uses nonce verification, honeypot, server validation and five submissions per IP per hour.

## SEO and performance
The theme has a crawlable front page and case-study URLs, title-tag support and Person JSON-LD. Use an SEO plugin for canonical URLs, XML sitemap, breadcrumbs and complete social cards. Optimize images, use caching/CDN, and use a global host/edge network for US/EU delivery. Keep JavaScript deferred and test caching plugins before launch.

## Production scope
This repository contains a complete responsive Classic theme foundation, CPTs, native meta, theme settings, REST contact handling and no fabricated case-study/testimonial data. A full Three.js Lenis/GSAP flight, overlays, texture streaming and full schema suite are staged enhancements rather than simulated through fake content.
