# Google FAQs plugin

Allows for the creation of [JSON-LD FAQ content](https://developers.google.com/search/docs/data-types/faqpage) for
Google and other JSON-LD compatible search engines. This allows site developers to provide answers to frequently-asked
questions in the context of a page.

## Features

- Easy management of questions and answers within October CMS.
- Compatibility with CMS Pages and Static Pages from the [RainLab Pages plugin](https://octobercms.com/plugin/rainlab-pages).

## Requirements

This plugin must be installed with the [Meta Plugin](https://octobercms.com/plugin/bennothommo-meta) to provide a
mechanism for injecting the JSON-LD content in your site. You will need to place the "jsonLdList" component in your
layout or page in which you would like the JSON-LD content to appear - this should generally be added within the `<head>`
tag on your website. You must also ensure that the "escape" parameter is unticked.
