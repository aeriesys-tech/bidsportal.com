
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bids Portal - Email Template</title>
  <style>
    /* Reset and base styles */
    *, *::before, *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    
    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
      line-height: 1.5;
      color: #374151;
      background-color: #f9fafb;
    }
    
    /* Custom styles */
    .gpt-selector-tooltip { position: fixed; z-index: 10000; pointer-events: none; background-color: rgb(13, 162, 231); color: white; padding: 4px 8px; border-radius: 4px; font-size: 14px; font-weight: bold; line-height: 1; white-space: nowrap; display: none; box-shadow: rgba(0, 0, 0, 0.2) 0px 2px 4px; transition: opacity 0.2s ease-in-out; margin: 0px; }
[data-lov-hovered] { position: relative; }
[data-lov-hovered]::before { content: ""; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; border-radius: 0px; z-index: 10000; pointer-events: none; outline: rgb(13, 162, 231) dashed 1px !important; outline-offset: 0px !important; background-color: rgba(13, 162, 231, 0.1) !important; }
[data-lov-selected] { position: relative; }
[data-lov-selected]::before { content: ""; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; border-radius: 0px; transition: outline-offset 0.2s ease-in-out; z-index: 10000; pointer-events: none; outline: rgb(13, 162, 231) dashed 1px !important; outline-offset: 3px !important; }
[data-lov-selected][contenteditable] { outline: none !important; }
[data-lov-hovered][data-full-width]::before, [data-lov-selected][data-full-width]::before { outline-offset: -5px !important; }
:where(html[dir="ltr"]), :where([data-sonner-toaster][dir="ltr"]) { --toast-icon-margin-start: -3px; --toast-icon-margin-end: 4px; --toast-svg-margin-start: -1px; --toast-svg-margin-end: 0px; --toast-button-margin-start: auto; --toast-button-margin-end: 0; --toast-close-button-start: 0; --toast-close-button-end: unset; --toast-close-button-transform: translate(-35%, -35%); }
:where(html[dir="rtl"]), :where([data-sonner-toaster][dir="rtl"]) { --toast-icon-margin-start: 4px; --toast-icon-margin-end: -3px; --toast-svg-margin-start: 0px; --toast-svg-margin-end: -1px; --toast-button-margin-start: 0; --toast-button-margin-end: auto; --toast-close-button-start: unset; --toast-close-button-end: 0; --toast-close-button-transform: translate(35%, -35%); }
:where([data-sonner-toaster]) { position: fixed; width: var(--width); font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"; --gray1: hsl(0, 0%, 99%); --gray2: hsl(0, 0%, 97.3%); --gray3: hsl(0, 0%, 95.1%); --gray4: hsl(0, 0%, 93%); --gray5: hsl(0, 0%, 90.9%); --gray6: hsl(0, 0%, 88.7%); --gray7: hsl(0, 0%, 85.8%); --gray8: hsl(0, 0%, 78%); --gray9: hsl(0, 0%, 56.1%); --gray10: hsl(0, 0%, 52.3%); --gray11: hsl(0, 0%, 43.5%); --gray12: hsl(0, 0%, 9%); --border-radius: 8px; box-sizing: border-box; padding: 0px; margin: 0px; list-style: none; outline: none; z-index: 999999999; }
:where([data-sonner-toaster][data-x-position="right"]) { right: max(var(--offset),env(safe-area-inset-right)); }
:where([data-sonner-toaster][data-x-position="left"]) { left: max(var(--offset),env(safe-area-inset-left)); }
:where([data-sonner-toaster][data-x-position="center"]) { left: 50%; transform: translate(-50%); }
:where([data-sonner-toaster][data-y-position="top"]) { top: max(var(--offset),env(safe-area-inset-top)); }
:where([data-sonner-toaster][data-y-position="bottom"]) { bottom: max(var(--offset),env(safe-area-inset-bottom)); }
:where([data-sonner-toast]) { --y: translateY(100%); --lift-amount: calc(var(--lift) * var(--gap)); z-index: var(--z-index); position: absolute; opacity: 0; transform: var(--y); filter: blur(0px); touch-action: none; transition: transform 0.4s, opacity 0.4s, height 0.4s, box-shadow 0.2s; box-sizing: border-box; outline: none; overflow-wrap: anywhere; }
:where([data-sonner-toast][data-styled="true"]) { padding: 16px; background: var(--normal-bg); border: 1px solid var(--normal-border); color: var(--normal-text); border-radius: var(--border-radius); box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px; width: var(--width); font-size: 13px; display: flex; align-items: center; gap: 6px; }
:where([data-sonner-toast]:focus-visible) { box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px, rgba(0, 0, 0, 0.2) 0px 0px 0px 2px; }
:where([data-sonner-toast][data-y-position="top"]) { top: 0px; --y: translateY(-100%); --lift: 1; --lift-amount: calc(1 * var(--gap)); }
:where([data-sonner-toast][data-y-position="bottom"]) { bottom: 0px; --y: translateY(100%); --lift: -1; --lift-amount: calc(var(--lift) * var(--gap)); }
:where([data-sonner-toast]) :where([data-description]) { font-weight: 400; line-height: 1.4; color: inherit; }
:where([data-sonner-toast]) :where([data-title]) { font-weight: 500; line-height: 1.5; color: inherit; }
:where([data-sonner-toast]) :where([data-icon]) { display: flex; height: 16px; width: 16px; position: relative; justify-content: flex-start; align-items: center; flex-shrink: 0; margin-left: var(--toast-icon-margin-start); margin-right: var(--toast-icon-margin-end); }
:where([data-sonner-toast][data-promise="true"]) :where([data-icon]) > svg { opacity: 0; transform: scale(0.8); transform-origin: center center; animation: 0.3s ease 0s 1 normal forwards running sonner-fade-in; }
:where([data-sonner-toast]) :where([data-icon]) > * { flex-shrink: 0; }
:where([data-sonner-toast]) :where([data-icon]) svg { margin-left: var(--toast-svg-margin-start); margin-right: var(--toast-svg-margin-end); }
:where([data-sonner-toast]) :where([data-content]) { display: flex; flex-direction: column; gap: 2px; }
[data-sonner-toast][data-styled="true"] [data-button] { border-radius: 4px; padding-left: 8px; padding-right: 8px; height: 24px; font-size: 12px; color: var(--normal-bg); background: var(--normal-text); margin-left: var(--toast-button-margin-start); margin-right: var(--toast-button-margin-end); border: none; cursor: pointer; outline: none; display: flex; align-items: center; flex-shrink: 0; transition: opacity 0.4s, box-shadow 0.2s; }
:where([data-sonner-toast]) :where([data-button]):focus-visible { box-shadow: rgba(0, 0, 0, 0.4) 0px 0px 0px 2px; }
:where([data-sonner-toast]) :where([data-button]):first-of-type { margin-left: var(--toast-button-margin-start); margin-right: var(--toast-button-margin-end); }
:where([data-sonner-toast]) :where([data-cancel]) { color: var(--normal-text); background: rgba(0, 0, 0, 0.08); }
:where([data-sonner-toast][data-theme="dark"]) :where([data-cancel]) { background: rgba(255, 255, 255, 0.3); }
:where([data-sonner-toast]) :where([data-close-button]) { position: absolute; left: var(--toast-close-button-start); right: var(--toast-close-button-end); top: 0px; height: 20px; width: 20px; display: flex; justify-content: center; align-items: center; padding: 0px; background: var(--gray1); color: var(--gray12); border: 1px solid var(--gray4); transform: var(--toast-close-button-transform); border-radius: 50%; cursor: pointer; z-index: 1; transition: opacity 0.1s, background 0.2s, border-color 0.2s; }
:where([data-sonner-toast]) :where([data-close-button]):focus-visible { box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px, rgba(0, 0, 0, 0.2) 0px 0px 0px 2px; }
:where([data-sonner-toast]) :where([data-disabled="true"]) { cursor: not-allowed; }
:where([data-sonner-toast]):hover :where([data-close-button]):hover { background: var(--gray2); border-color: var(--gray5); }
:where([data-sonner-toast][data-swiping="true"])::before { content: ""; position: absolute; left: 0px; right: 0px; height: 100%; z-index: -1; }
:where([data-sonner-toast][data-y-position="top"][data-swiping="true"])::before { bottom: 50%; transform: scaleY(3) translateY(50%); }
:where([data-sonner-toast][data-y-position="bottom"][data-swiping="true"])::before { top: 50%; transform: scaleY(3) translateY(-50%); }
:where([data-sonner-toast][data-swiping="false"][data-removed="true"])::before { content: ""; position: absolute; inset: 0px; transform: scaleY(2); }
:where([data-sonner-toast])::after { content: ""; position: absolute; left: 0px; height: calc(var(--gap) + 1px); bottom: 100%; width: 100%; }
:where([data-sonner-toast][data-mounted="true"]) { --y: translateY(0); opacity: 1; }
:where([data-sonner-toast][data-expanded="false"][data-front="false"]) { --scale: var(--toasts-before) * .05 + 1; --y: translateY(calc(var(--lift-amount) * var(--toasts-before))) scale(calc(-1 * var(--scale))); height: var(--front-toast-height); }
:where([data-sonner-toast]) > * { transition: opacity 0.4s; }
:where([data-sonner-toast][data-expanded="false"][data-front="false"][data-styled="true"]) > * { opacity: 0; }
:where([data-sonner-toast][data-visible="false"]) { opacity: 0; pointer-events: none; }
:where([data-sonner-toast][data-mounted="true"][data-expanded="true"]) { --y: translateY(calc(var(--lift) * var(--offset))); height: var(--initial-height); }
:where([data-sonner-toast][data-removed="true"][data-front="true"][data-swipe-out="false"]) { --y: translateY(calc(var(--lift) * -100%)); opacity: 0; }
:where([data-sonner-toast][data-removed="true"][data-front="false"][data-swipe-out="false"][data-expanded="true"]) { --y: translateY(calc(var(--lift) * var(--offset) + var(--lift) * -100%)); opacity: 0; }
:where([data-sonner-toast][data-removed="true"][data-front="false"][data-swipe-out="false"][data-expanded="false"]) { --y: translateY(40%); opacity: 0; transition: transform 0.5s, opacity 0.2s; }
:where([data-sonner-toast][data-removed="true"][data-front="false"])::before { height: calc(var(--initial-height) + 20%); }
[data-sonner-toast][data-swiping="true"] { transform: var(--y) translateY(var(--swipe-amount, 0px)); transition: none; }
[data-sonner-toast][data-swipe-out="true"][data-y-position="bottom"], [data-sonner-toast][data-swipe-out="true"][data-y-position="top"] { animation: 0.2s ease-out 0s 1 normal forwards running swipe-out; }
@keyframes swipe-out { 
  0% { transform: translateY(calc(var(--lift) * var(--offset) + var(--swipe-amount))); opacity: 1; }
  100% { transform: translateY(calc(var(--lift) * var(--offset) + var(--swipe-amount) + var(--lift) * -100%)); opacity: 0; }
}
@media (max-width: 600px) {
  [data-sonner-toaster] { position: fixed; --mobile-offset: 16px; right: var(--mobile-offset); left: var(--mobile-offset); width: 100%; }
  [data-sonner-toaster] [data-sonner-toast] { left: 0px; right: 0px; width: calc(100% - var(--mobile-offset) * 2); }
  [data-sonner-toaster][data-x-position="left"] { left: var(--mobile-offset); }
  [data-sonner-toaster][data-y-position="bottom"] { bottom: 20px; }
  [data-sonner-toaster][data-y-position="top"] { top: 20px; }
  [data-sonner-toaster][data-x-position="center"] { left: var(--mobile-offset); right: var(--mobile-offset); transform: none; }
}
[data-sonner-toaster][data-theme="light"] { --normal-bg: #fff; --normal-border: var(--gray4); --normal-text: var(--gray12); --success-bg: hsl(143, 85%, 96%); --success-border: hsl(145, 92%, 91%); --success-text: hsl(140, 100%, 27%); --info-bg: hsl(208, 100%, 97%); --info-border: hsl(221, 91%, 91%); --info-text: hsl(210, 92%, 45%); --warning-bg: hsl(49, 100%, 97%); --warning-border: hsl(49, 91%, 91%); --warning-text: hsl(31, 92%, 45%); --error-bg: hsl(359, 100%, 97%); --error-border: hsl(359, 100%, 94%); --error-text: hsl(360, 100%, 45%); }
[data-sonner-toaster][data-theme="light"] [data-sonner-toast][data-invert="true"] { --normal-bg: #000; --normal-border: hsl(0, 0%, 20%); --normal-text: var(--gray1); }
[data-sonner-toaster][data-theme="dark"] [data-sonner-toast][data-invert="true"] { --normal-bg: #fff; --normal-border: var(--gray3); --normal-text: var(--gray12); }
[data-sonner-toaster][data-theme="dark"] { --normal-bg: #000; --normal-border: hsl(0, 0%, 20%); --normal-text: var(--gray1); --success-bg: hsl(150, 100%, 6%); --success-border: hsl(147, 100%, 12%); --success-text: hsl(150, 86%, 65%); --info-bg: hsl(215, 100%, 6%); --info-border: hsl(223, 100%, 12%); --info-text: hsl(216, 87%, 65%); --warning-bg: hsl(64, 100%, 6%); --warning-border: hsl(60, 100%, 12%); --warning-text: hsl(46, 87%, 65%); --error-bg: hsl(358, 76%, 10%); --error-border: hsl(357, 89%, 16%); --error-text: hsl(358, 100%, 81%); }
[data-rich-colors="true"][data-sonner-toast][data-type="success"], [data-rich-colors="true"][data-sonner-toast][data-type="success"] [data-close-button] { background: var(--success-bg); border-color: var(--success-border); color: var(--success-text); }
[data-rich-colors="true"][data-sonner-toast][data-type="info"], [data-rich-colors="true"][data-sonner-toast][data-type="info"] [data-close-button] { background: var(--info-bg); border-color: var(--info-border); color: var(--info-text); }
[data-rich-colors="true"][data-sonner-toast][data-type="warning"], [data-rich-colors="true"][data-sonner-toast][data-type="warning"] [data-close-button] { background: var(--warning-bg); border-color: var(--warning-border); color: var(--warning-text); }
[data-rich-colors="true"][data-sonner-toast][data-type="error"], [data-rich-colors="true"][data-sonner-toast][data-type="error"] [data-close-button] { background: var(--error-bg); border-color: var(--error-border); color: var(--error-text); }
.sonner-loading-wrapper { --size: 16px; height: var(--size); width: var(--size); position: absolute; inset: 0px; z-index: 10; }
.sonner-loading-wrapper[data-visible="false"] { transform-origin: center center; animation: 0.2s ease 0s 1 normal forwards running sonner-fade-out; }
.sonner-spinner { position: relative; top: 50%; left: 50%; height: var(--size); width: var(--size); }
.sonner-loading-bar { animation: 1.2s linear 0s infinite normal none running sonner-spin; background: var(--gray11); border-radius: 6px; height: 8%; left: -10%; position: absolute; top: -3.9%; width: 24%; }
.sonner-loading-bar:nth-child(1) { animation-delay: -1.2s; transform: rotate(0.0001deg) translate(146%); }
.sonner-loading-bar:nth-child(2) { animation-delay: -1.1s; transform: rotate(30deg) translate(146%); }
.sonner-loading-bar:nth-child(3) { animation-delay: -1s; transform: rotate(60deg) translate(146%); }
.sonner-loading-bar:nth-child(4) { animation-delay: -0.9s; transform: rotate(90deg) translate(146%); }
.sonner-loading-bar:nth-child(5) { animation-delay: -0.8s; transform: rotate(120deg) translate(146%); }
.sonner-loading-bar:nth-child(6) { animation-delay: -0.7s; transform: rotate(150deg) translate(146%); }
.sonner-loading-bar:nth-child(7) { animation-delay: -0.6s; transform: rotate(180deg) translate(146%); }
.sonner-loading-bar:nth-child(8) { animation-delay: -0.5s; transform: rotate(210deg) translate(146%); }
.sonner-loading-bar:nth-child(9) { animation-delay: -0.4s; transform: rotate(240deg) translate(146%); }
.sonner-loading-bar:nth-child(10) { animation-delay: -0.3s; transform: rotate(270deg) translate(146%); }
.sonner-loading-bar:nth-child(11) { animation-delay: -0.2s; transform: rotate(300deg) translate(146%); }
.sonner-loading-bar:nth-child(12) { animation-delay: -0.1s; transform: rotate(330deg) translate(146%); }
@keyframes sonner-fade-in { 
  0% { opacity: 0; transform: scale(0.8); }
  100% { opacity: 1; transform: scale(1); }
}
@keyframes sonner-fade-out { 
  0% { opacity: 1; transform: scale(1); }
  100% { opacity: 0; transform: scale(0.8); }
}
@keyframes sonner-spin { 
  0% { opacity: 1; }
  100% { opacity: 0.15; }
}
@media (prefers-reduced-motion) {
  [data-sonner-toast], [data-sonner-toast] > *, .sonner-loading-bar { transition: none !important; animation: auto ease 0s 1 normal none running none !important; }
}
.sonner-loader { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); transform-origin: center center; transition: opacity 0.2s, transform 0.2s; }
.sonner-loader[data-visible="false"] { opacity: 0; transform: scale(0.8) translate(-50%, -50%); }
*, ::before, ::after { box-sizing: border-box; border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); }
::before, ::after { --tw-content: ''; }
html, :host { line-height: 1.5; text-size-adjust: 100%; tab-size: 4; font-family: "SF Pro Display", system-ui, sans-serif; font-feature-settings: normal; font-variation-settings: normal; -webkit-tap-highlight-color: transparent; }
body { margin: 0px; line-height: inherit; }
hr { height: 0px; color: inherit; border-top-width: 1px; }
abbr:where([title]) { text-decoration: underline dotted; }
h1, h2, h3, h4, h5, h6 { font-size: inherit; font-weight: inherit; }
a { color: inherit; text-decoration: inherit; }
b, strong { font-weight: bolder; }
code, kbd, samp, pre { font-family: "SF Mono", monospace; font-feature-settings: normal; font-variation-settings: normal; font-size: 1em; }
small { font-size: 80%; }
sub, sup { font-size: 75%; line-height: 0; position: relative; vertical-align: baseline; }
sub { bottom: -0.25em; }
sup { top: -0.5em; }
table { text-indent: 0px; border-color: inherit; border-collapse: collapse; }
button, input, optgroup, select, textarea { font-family: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-size: 100%; font-weight: inherit; line-height: inherit; letter-spacing: inherit; color: inherit; margin: 0px; padding: 0px; }
button, select { text-transform: none; }
button, input:where([type="button"]), input:where([type="reset"]), input:where([type="submit"]) { appearance: button; background-color: transparent; background-image: none; }
progress { vertical-align: baseline; }
::-webkit-inner-spin-button, ::-webkit-outer-spin-button { height: auto; }
[type="search"] { appearance: textfield; outline-offset: -2px; }
::-webkit-search-decoration { appearance: none; }
::-webkit-file-upload-button { appearance: button; font: inherit; }
summary { display: list-item; }
blockquote, dl, dd, h1, h2, h3, h4, h5, h6, hr, figure, p, pre { margin: 0px; }
fieldset { margin: 0px; padding: 0px; }
legend { padding: 0px; }
ol, ul, menu { list-style: none; margin: 0px; padding: 0px; }
dialog { padding: 0px; }
textarea { resize: vertical; }
input::placeholder, textarea::placeholder { opacity: 1; color: rgb(156, 163, 175); }
button, [role="button"] { cursor: pointer; }
:disabled { cursor: default; }
img, svg, video, canvas, audio, iframe, embed, object { display: block; vertical-align: middle; }
img, video { max-width: 100%; height: auto; }
[hidden] { display: none; }
:root { --background: 0 0% 100%; --foreground: 222.2 84% 4.9%; --card: 0 0% 100%; --card-foreground: 222.2 84% 4.9%; --popover: 0 0% 100%; --popover-foreground: 222.2 84% 4.9%; --primary: 215 50% 23%; --primary-foreground: 210 40% 98%; --secondary: 210 40% 96.1%; --secondary-foreground: 222.2 47.4% 11.2%; --muted: 210 40% 96.1%; --muted-foreground: 215.4 16.3% 46.9%; --accent: 210 40% 96.1%; --accent-foreground: 222.2 47.4% 11.2%; --destructive: 0 84.2% 60.2%; --destructive-foreground: 210 40% 98%; --border: 214.3 31.8% 91.4%; --input: 214.3 31.8% 91.4%; --ring: 222.2 84% 4.9%; --radius: 0.8rem; --sidebar-background: 0 0% 98%; --sidebar-foreground: 240 5.3% 26.1%; --sidebar-primary: 240 5.9% 10%; --sidebar-primary-foreground: 0 0% 98%; --sidebar-accent: 240 4.8% 95.9%; --sidebar-accent-foreground: 240 5.9% 10%; --sidebar-border: 220 13% 91%; --sidebar-ring: 217.2 91.2% 59.8%; }
.dark { --background: 222.2 84% 4.9%; --foreground: 210 40% 98%; --card: 222.2 84% 4.9%; --card-foreground: 210 40% 98%; --popover: 222.2 84% 4.9%; --popover-foreground: 210 40% 98%; --primary: 210 40% 98%; --primary-foreground: 222.2 47.4% 11.2%; --secondary: 217.2 32.6% 17.5%; --secondary-foreground: 210 40% 98%; --muted: 217.2 32.6% 17.5%; --muted-foreground: 215 20.2% 65.1%; --accent: 217.2 32.6% 17.5%; --accent-foreground: 210 40% 98%; --destructive: 0 62.8% 30.6%; --destructive-foreground: 210 40% 98%; --border: 217.2 32.6% 17.5%; --input: 217.2 32.6% 17.5%; --ring: 212.7 26.8% 83.9%; --sidebar-background: 240 5.9% 10%; --sidebar-foreground: 240 4.8% 95.9%; --sidebar-primary: 224.3 76.3% 48%; --sidebar-primary-foreground: 0 0% 100%; --sidebar-accent: 240 3.7% 15.9%; --sidebar-accent-foreground: 240 4.8% 95.9%; --sidebar-border: 240 3.7% 15.9%; --sidebar-ring: 217.2 91.2% 59.8%; }
@font-face { font-family: "SF Pro Display"; src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-regular-webfont.woff2") format("woff2"); font-weight: 400; font-style: normal; font-display: swap; }
@font-face { font-family: "SF Pro Display"; src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-medium-webfont.woff2") format("woff2"); font-weight: 500; font-style: normal; font-display: swap; }
@font-face { font-family: "SF Pro Display"; src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-semibold-webfont.woff2") format("woff2"); font-weight: 600; font-style: normal; font-display: swap; }
@font-face { font-family: "SF Pro Display"; src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-bold-webfont.woff2") format("woff2"); font-weight: 700; font-style: normal; font-display: swap; }
@font-face { font-family: "SF Mono"; src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/SFMono-Regular.woff2") format("woff2"); font-weight: 400; font-style: normal; font-display: swap; }
* { border-color: hsl(var(--border)); }
body { background-color: hsl(var(--background)); font-family: "SF Pro Display", system-ui, sans-serif; color: hsl(var(--foreground)); -webkit-font-smoothing: antialiased; }
h1, h2, h3, h4, h5, h6 { font-family: "SF Pro Display", system-ui, sans-serif; letter-spacing: -0.025em; }
code, pre { font-family: "SF Mono", monospace; }
*, ::before, ::after { --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgb(59 130 246 / 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; }
::backdrop { --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgb(59 130 246 / 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; }
.sr-only { position: absolute; width: 1px; height: 1px; padding: 0px; margin: -1px; overflow: hidden; clip: rect(0px, 0px, 0px, 0px); white-space: nowrap; border-width: 0px; }
.pointer-events-none { pointer-events: none; }
.pointer-events-auto { pointer-events: auto; }
.visible { visibility: visible; }
.invisible { visibility: hidden; }
.collapse { visibility: collapse; }
.fixed { position: fixed; }
.absolute { position: absolute; }
.relative { position: relative; }
.inset-0 { inset: 0px; }
.inset-x-0 { left: 0px; right: 0px; }
.inset-y-0 { top: 0px; bottom: 0px; }
.-bottom-12 { bottom: -3rem; }
.-left-12 { left: -3rem; }
.-right-12 { right: -3rem; }
.-top-12 { top: -3rem; }
.bottom-0 { bottom: 0px; }
.left-0 { left: 0px; }
.left-1 { left: 0.25rem; }
.left-1\/2 { left: 50%; }
.left-2 { left: 0.5rem; }
.left-\[50\%\] { left: 50%; }
.right-0 { right: 0px; }
.right-1 { right: 0.25rem; }
.right-2 { right: 0.5rem; }
.right-3 { right: 0.75rem; }
.right-4 { right: 1rem; }
.top-0 { top: 0px; }
.top-1\.5 { top: 0.375rem; }
.top-1\/2 { top: 50%; }
.top-2 { top: 0.5rem; }
.top-3\.5 { top: 0.875rem; }
.top-4 { top: 1rem; }
.top-\[1px\] { top: 1px; }
.top-\[50\%\] { top: 50%; }
.top-\[60\%\] { top: 60%; }
.top-full { top: 100%; }
.z-10 { z-index: 10; }
.z-20 { z-index: 20; }
.z-50 { z-index: 50; }
.z-\[100\] { z-index: 100; }
.z-\[1\] { z-index: 1; }
.-mx-1 { margin-left: -0.25rem; margin-right: -0.25rem; }
.mx-2 { margin-left: 0.5rem; margin-right: 0.5rem; }
.mx-3\.5 { margin-left: 0.875rem; margin-right: 0.875rem; }
.mx-auto { margin-left: auto; margin-right: auto; }
.my-0\.5 { margin-top: 0.125rem; margin-bottom: 0.125rem; }
.my-1 { margin-top: 0.25rem; margin-bottom: 0.25rem; }
.-ml-4 { margin-left: -1rem; }
.-mt-4 { margin-top: -1rem; }
.mb-1 { margin-bottom: 0.25rem; }
.mb-2 { margin-bottom: 0.5rem; }
.mb-3 { margin-bottom: 0.75rem; }
.mb-4 { margin-bottom: 1rem; }
.mb-6 { margin-bottom: 1.5rem; }
.mb-8 { margin-bottom: 2rem; }
.ml-1 { margin-left: 0.25rem; }
.ml-4 { margin-left: 1rem; }
.ml-8 { margin-left: 2rem; }
.ml-auto { margin-left: auto; }
.mr-1 { margin-right: 0.25rem; }
.mr-1\.5 { margin-right: 0.375rem; }
.mr-2 { margin-right: 0.5rem; }
.mr-3 { margin-right: 0.75rem; }
.mt-1 { margin-top: 0.25rem; }
.mt-1\.5 { margin-top: 0.375rem; }
.mt-2 { margin-top: 0.5rem; }
.mt-24 { margin-top: 6rem; }
.mt-4 { margin-top: 1rem; }
.mt-8 { margin-top: 2rem; }
.mt-auto { margin-top: auto; }
.line-clamp-2 { overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; }
.block { display: block; }
.inline { display: inline; }
.flex { display: flex; }
.inline-flex { display: inline-flex; }
.table { display: table; }
.grid { display: grid; }
.hidden { display: none; }
.aspect-square { aspect-ratio: 1 / 1; }
.aspect-video { aspect-ratio: 16 / 9; }
.size-4 { width: 1rem; height: 1rem; }
.h-1\.5 { height: 0.375rem; }
.h-10 { height: 2.5rem; }
.h-11 { height: 2.75rem; }
.h-12 { height: 3rem; }
.h-2 { height: 0.5rem; }
.h-2\.5 { height: 0.625rem; }
.h-3 { height: 0.75rem; }
.h-3\.5 { height: 0.875rem; }
.h-4 { height: 1rem; }
.h-5 { height: 1.25rem; }
.h-6 { height: 1.5rem; }
.h-7 { height: 1.75rem; }
.h-8 { height: 2rem; }
.h-9 { height: 2.25rem; }
.h-\[1px\] { height: 1px; }
.h-\[var\(--radix-navigation-menu-viewport-height\)\] { height: var(--radix-navigation-menu-viewport-height); }
.h-\[var\(--radix-select-trigger-height\)\] { height: var(--radix-select-trigger-height); }
.h-auto { height: auto; }
.h-full { height: 100%; }
.h-px { height: 1px; }
.h-svh { height: 100svh; }
.max-h-96 { max-height: 24rem; }
.max-h-\[300px\] { max-height: 300px; }
.max-h-screen { max-height: 100vh; }
.min-h-0 { min-height: 0px; }
.min-h-\[80px\] { min-height: 80px; }
.min-h-screen { min-height: 100vh; }
.min-h-svh { min-height: 100svh; }
.w-0 { width: 0px; }
.w-1 { width: 0.25rem; }
.w-10 { width: 2.5rem; }
.w-11 { width: 2.75rem; }
.w-2 { width: 0.5rem; }
.w-2\.5 { width: 0.625rem; }
.w-3 { width: 0.75rem; }
.w-3\.5 { width: 0.875rem; }
.w-3\/4 { width: 75%; }
.w-4 { width: 1rem; }
.w-5 { width: 1.25rem; }
.w-6 { width: 1.5rem; }
.w-64 { width: 16rem; }
.w-7 { width: 1.75rem; }
.w-72 { width: 18rem; }
.w-8 { width: 2rem; }
.w-9 { width: 2.25rem; }
.w-\[--sidebar-width\] { width: var(--sidebar-width); }
.w-\[100px\] { width: 100px; }
.w-\[1px\] { width: 1px; }
.w-auto { width: auto; }
.w-full { width: 100%; }
.w-max { width: max-content; }
.w-px { width: 1px; }
.min-w-0 { min-width: 0px; }
.min-w-5 { min-width: 1.25rem; }
.min-w-\[12rem\] { min-width: 12rem; }
.min-w-\[8rem\] { min-width: 8rem; }
.min-w-\[var\(--radix-select-trigger-width\)\] { min-width: var(--radix-select-trigger-width); }
.min-w-full { min-width: 100%; }
.max-w-2xl { max-width: 42rem; }
.max-w-4xl { max-width: 56rem; }
.max-w-\[--skeleton-width\] { max-width: var(--skeleton-width); }
.max-w-lg { max-width: 32rem; }
.max-w-max { max-width: max-content; }
.max-w-md { max-width: 28rem; }
.flex-1 { flex: 1 1 0%; }
.flex-shrink-0 { flex-shrink: 0; }
.shrink-0 { flex-shrink: 0; }
.grow { flex-grow: 1; }
.grow-0 { flex-grow: 0; }
.basis-full { flex-basis: 100%; }
.caption-bottom { caption-side: bottom; }
.border-collapse { border-collapse: collapse; }
.-translate-x-1\/2 { --tw-translate-x: -50%; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.-translate-x-px { --tw-translate-x: -1px; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.-translate-y-1\/2 { --tw-translate-y: -50%; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.translate-x-\[-50\%\] { --tw-translate-x: -50%; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.translate-x-px { --tw-translate-x: 1px; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.translate-y-\[-50\%\] { --tw-translate-y: -50%; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.rotate-45 { --tw-rotate: 45deg; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.rotate-90 { --tw-rotate: 90deg; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.transform { transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
@keyframes pulse { 
  50% { opacity: 0.5; }
}
.animate-pulse { animation: 2s cubic-bezier(0.4, 0, 0.6, 1) 0s infinite normal none running pulse; }
@keyframes slide-up { 
  0% { transform: translateY(10px); opacity: 0; }
  100% { transform: translateY(0px); opacity: 1; }
}
.animate-slide-up { animation: 0.4s ease-out 0s 1 normal none running slide-up; }
.cursor-default { cursor: default; }
.cursor-pointer { cursor: pointer; }
.touch-none { touch-action: none; }
.select-none { user-select: none; }
.list-disc { list-style-type: disc; }
.list-none { list-style-type: none; }
.grid-cols-2 { grid-template-columns: repeat(2, minmax(0px, 1fr)); }
.flex-row { flex-direction: row; }
.flex-col { flex-direction: column; }
.flex-col-reverse { flex-direction: column-reverse; }
.flex-wrap { flex-wrap: wrap; }
.items-start { align-items: flex-start; }
.items-end { align-items: flex-end; }
.items-center { align-items: center; }
.items-stretch { align-items: stretch; }
.justify-end { justify-content: flex-end; }
.justify-center { justify-content: center; }
.justify-between { justify-content: space-between; }
.gap-1 { gap: 0.25rem; }
.gap-1\.5 { gap: 0.375rem; }
.gap-2 { gap: 0.5rem; }
.gap-4 { gap: 1rem; }
.gap-x-4 { column-gap: 1rem; }
.gap-y-1 { row-gap: 0.25rem; }
.space-x-1 > :not([hidden]) ~ :not([hidden]) { --tw-space-x-reverse: 0; margin-right: calc(0.25rem * var(--tw-space-x-reverse)); margin-left: calc(0.25rem * calc(1 - var(--tw-space-x-reverse))); }
.space-x-2 > :not([hidden]) ~ :not([hidden]) { --tw-space-x-reverse: 0; margin-right: calc(0.5rem * var(--tw-space-x-reverse)); margin-left: calc(0.5rem * calc(1 - var(--tw-space-x-reverse))); }
.space-x-3 > :not([hidden]) ~ :not([hidden]) { --tw-space-x-reverse: 0; margin-right: calc(0.75rem * var(--tw-space-x-reverse)); margin-left: calc(0.75rem * calc(1 - var(--tw-space-x-reverse))); }
.space-x-4 > :not([hidden]) ~ :not([hidden]) { --tw-space-x-reverse: 0; margin-right: calc(1rem * var(--tw-space-x-reverse)); margin-left: calc(1rem * calc(1 - var(--tw-space-x-reverse))); }
.space-y-1 > :not([hidden]) ~ :not([hidden]) { --tw-space-y-reverse: 0; margin-top: calc(0.25rem * calc(1 - var(--tw-space-y-reverse))); margin-bottom: calc(0.25rem * var(--tw-space-y-reverse)); }
.space-y-1\.5 > :not([hidden]) ~ :not([hidden]) { --tw-space-y-reverse: 0; margin-top: calc(0.375rem * calc(1 - var(--tw-space-y-reverse))); margin-bottom: calc(0.375rem * var(--tw-space-y-reverse)); }
.space-y-2 > :not([hidden]) ~ :not([hidden]) { --tw-space-y-reverse: 0; margin-top: calc(0.5rem * calc(1 - var(--tw-space-y-reverse))); margin-bottom: calc(0.5rem * var(--tw-space-y-reverse)); }
.space-y-3 > :not([hidden]) ~ :not([hidden]) { --tw-space-y-reverse: 0; margin-top: calc(0.75rem * calc(1 - var(--tw-space-y-reverse))); margin-bottom: calc(0.75rem * var(--tw-space-y-reverse)); }
.space-y-4 > :not([hidden]) ~ :not([hidden]) { --tw-space-y-reverse: 0; margin-top: calc(1rem * calc(1 - var(--tw-space-y-reverse))); margin-bottom: calc(1rem * var(--tw-space-y-reverse)); }
.space-y-8 > :not([hidden]) ~ :not([hidden]) { --tw-space-y-reverse: 0; margin-top: calc(2rem * calc(1 - var(--tw-space-y-reverse))); margin-bottom: calc(2rem * var(--tw-space-y-reverse)); }
.divide-y > :not([hidden]) ~ :not([hidden]) { --tw-divide-y-reverse: 0; border-top-width: calc(1px * calc(1 - var(--tw-divide-y-reverse))); border-bottom-width: calc(1px * var(--tw-divide-y-reverse)); }
.divide-gray-200 > :not([hidden]) ~ :not([hidden]) { --tw-divide-opacity: 1; border-color: rgb(229 231 235 / var(--tw-divide-opacity)); }
.self-end { align-self: flex-end; }
.overflow-auto { overflow: auto; }
.overflow-hidden { overflow: hidden; }
.overflow-x-auto { overflow-x: auto; }
.overflow-y-auto { overflow-y: auto; }
.overflow-x-hidden { overflow-x: hidden; }
.whitespace-nowrap { white-space: nowrap; }
.break-words { overflow-wrap: break-word; }
.rounded { border-radius: 0.25rem; }
.rounded-2xl { border-radius: 1rem; }
.rounded-\[2px\] { border-radius: 2px; }
.rounded-\[inherit\] { border-radius: inherit; }
.rounded-full { border-radius: 9999px; }
.rounded-lg { border-radius: var(--radius); }
.rounded-md { border-radius: calc(var(--radius) - 2px); }
.rounded-sm { border-radius: calc(var(--radius) - 4px); }
.rounded-xl { border-radius: 0.75rem; }
.rounded-t-\[10px\] { border-top-left-radius: 10px; border-top-right-radius: 10px; }
.rounded-tl-sm { border-top-left-radius: calc(var(--radius) - 4px); }
.border { border-width: 1px; }
.border-2 { border-width: 2px; }
.border-\[1\.5px\] { border-width: 1.5px; }
.border-y { border-top-width: 1px; border-bottom-width: 1px; }
.border-b { border-bottom-width: 1px; }
.border-l { border-left-width: 1px; }
.border-r { border-right-width: 1px; }
.border-t { border-top-width: 1px; }
.border-dashed { border-style: dashed; }
.border-\[--color-border\] { border-color: var(--color-border); }
.border-blue-200 { --tw-border-opacity: 1; border-color: rgb(191 219 254 / var(--tw-border-opacity)); }
.border-border\/50 { border-color: hsl(var(--border) / 0.5); }
.border-destructive { border-color: hsl(var(--destructive)); }
.border-destructive\/50 { border-color: hsl(var(--destructive) / 0.5); }
.border-gray-100 { --tw-border-opacity: 1; border-color: rgb(243 244 246 / var(--tw-border-opacity)); }
.border-gray-200 { --tw-border-opacity: 1; border-color: rgb(229 231 235 / var(--tw-border-opacity)); }
.border-gray-300 { --tw-border-opacity: 1; border-color: rgb(209 213 219 / var(--tw-border-opacity)); }
.border-input { border-color: hsl(var(--input)); }
.border-primary { border-color: hsl(var(--primary)); }
.border-sidebar-border { border-color: hsl(var(--sidebar-border)); }
.border-transparent { border-color: transparent; }
.border-l-transparent { border-left-color: transparent; }
.border-t-transparent { border-top-color: transparent; }
.bg-\[--color-bg\] { background-color: var(--color-bg); }
.bg-accent { background-color: hsl(var(--accent)); }
.bg-background { background-color: hsl(var(--background)); }
.bg-black\/80 { background-color: rgba(0, 0, 0, 0.8); }
.bg-blue-50 { --tw-bg-opacity: 1; background-color: rgb(239 246 255 / var(--tw-bg-opacity)); }
.bg-blue-50\/50 { background-color: rgba(239, 246, 255, 0.5); }
.bg-blue-500 { --tw-bg-opacity: 1; background-color: rgb(59 130 246 / var(--tw-bg-opacity)); }
.bg-border { background-color: hsl(var(--border)); }
.bg-card { background-color: hsl(var(--card)); }
.bg-destructive { background-color: hsl(var(--destructive)); }
.bg-foreground { background-color: hsl(var(--foreground)); }
.bg-gray-100 { --tw-bg-opacity: 1; background-color: rgb(243 244 246 / var(--tw-bg-opacity)); }
.bg-gray-300 { --tw-bg-opacity: 1; background-color: rgb(209 213 219 / var(--tw-bg-opacity)); }
.bg-gray-50 { --tw-bg-opacity: 1; background-color: rgb(249 250 251 / var(--tw-bg-opacity)); }
.bg-green-50 { --tw-bg-opacity: 1; background-color: rgb(240 253 244 / var(--tw-bg-opacity)); }
.bg-muted { background-color: hsl(var(--muted)); }
.bg-muted\/50 { background-color: hsl(var(--muted) / 0.5); }
.bg-orange-100 { --tw-bg-opacity: 1; background-color: rgb(255 237 213 / var(--tw-bg-opacity)); }
.bg-popover { background-color: hsl(var(--popover)); }
.bg-primary { background-color: hsl(var(--primary)); }
.bg-red-100 { --tw-bg-opacity: 1; background-color: rgb(254 226 226 / var(--tw-bg-opacity)); }
.bg-secondary { background-color: hsl(var(--secondary)); }
.bg-sidebar { background-color: hsl(var(--sidebar-background)); }
.bg-sidebar-border { background-color: hsl(var(--sidebar-border)); }
.bg-transparent { background-color: transparent; }
.bg-white { --tw-bg-opacity: 1; background-color: rgb(255 255 255 / var(--tw-bg-opacity)); }
.bg-gradient-to-b { background-image: linear-gradient(to bottom, var(--tw-gradient-stops)); }
.bg-gradient-to-br { background-image: linear-gradient(to bottom right, var(--tw-gradient-stops)); }
.bg-gradient-to-r { background-image: linear-gradient(to right, var(--tw-gradient-stops)); }
.from-blue-50 { --tw-gradient-from: #eff6ff var(--tw-gradient-from-position); --tw-gradient-to: rgb(239 246 255 / 0) var(--tw-gradient-to-position); --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to); }
.from-gray-50 { --tw-gradient-from: #f9fafb var(--tw-gradient-from-position); --tw-gradient-to: rgb(249 250 251 / 0) var(--tw-gradient-to-position); --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to); }
.via-white { --tw-gradient-to: rgb(255 255 255 / 0)  var(--tw-gradient-to-position); --tw-gradient-stops: var(--tw-gradient-from), #fff var(--tw-gradient-via-position), var(--tw-gradient-to); }
.to-gray-50 { --tw-gradient-to: #f9fafb var(--tw-gradient-to-position); }
.to-white { --tw-gradient-to: #fff var(--tw-gradient-to-position); }
.fill-current { fill: currentcolor; }
.p-0 { padding: 0px; }
.p-1 { padding: 0.25rem; }
.p-2 { padding: 0.5rem; }
.p-3 { padding: 0.75rem; }
.p-4 { padding: 1rem; }
.p-6 { padding: 1.5rem; }
.p-8 { padding: 2rem; }
.p-\[1px\] { padding: 1px; }
.px-1 { padding-left: 0.25rem; padding-right: 0.25rem; }
.px-2 { padding-left: 0.5rem; padding-right: 0.5rem; }
.px-2\.5 { padding-left: 0.625rem; padding-right: 0.625rem; }
.px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
.px-4 { padding-left: 1rem; padding-right: 1rem; }
.px-5 { padding-left: 1.25rem; padding-right: 1.25rem; }
.px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
.px-8 { padding-left: 2rem; padding-right: 2rem; }
.py-0\.5 { padding-top: 0.125rem; padding-bottom: 0.125rem; }
.py-1 { padding-top: 0.25rem; padding-bottom: 0.25rem; }
.py-1\.5 { padding-top: 0.375rem; padding-bottom: 0.375rem; }
.py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
.py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
.py-4 { padding-top: 1rem; padding-bottom: 1rem; }
.py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
.py-8 { padding-top: 2rem; padding-bottom: 2rem; }
.pb-2 { padding-bottom: 0.5rem; }
.pb-3 { padding-bottom: 0.75rem; }
.pb-4 { padding-bottom: 1rem; }
.pl-2\.5 { padding-left: 0.625rem; }
.pl-4 { padding-left: 1rem; }
.pl-6 { padding-left: 1.5rem; }
.pl-8 { padding-left: 2rem; }
.pr-2 { padding-right: 0.5rem; }
.pr-2\.5 { padding-right: 0.625rem; }
.pr-8 { padding-right: 2rem; }
.pt-0 { padding-top: 0px; }
.pt-1 { padding-top: 0.25rem; }
.pt-3 { padding-top: 0.75rem; }
.pt-4 { padding-top: 1rem; }
.text-left { text-align: left; }
.text-center { text-align: center; }
.align-middle { vertical-align: middle; }
.font-mono { font-family: "SF Mono", monospace; }
.font-sans { font-family: "SF Pro Display", system-ui, sans-serif; }
.text-2xl { font-size: 1.5rem; line-height: 2rem; }
.text-4xl { font-size: 2.25rem; line-height: 2.5rem; }
.text-5xl { font-size: 3rem; line-height: 1; }
.text-\[0\.8rem\] { font-size: 0.8rem; }
.text-base { font-size: 1rem; line-height: 1.5rem; }
.text-lg { font-size: 1.125rem; line-height: 1.75rem; }
.text-sm { font-size: 0.875rem; line-height: 1.25rem; }
.text-xl { font-size: 1.25rem; line-height: 1.75rem; }
.text-xs { font-size: 0.75rem; line-height: 1rem; }
.font-bold { font-weight: 700; }
.font-medium { font-weight: 500; }
.font-normal { font-weight: 400; }
.font-semibold { font-weight: 600; }
.uppercase { text-transform: uppercase; }
.italic { font-style: italic; }
.tabular-nums { --tw-numeric-spacing: tabular-nums; font-variant-numeric: var(--tw-ordinal) var(--tw-slashed-zero) var(--tw-numeric-figure) var(--tw-numeric-spacing) var(--tw-numeric-fraction); }
.leading-none { line-height: 1; }
.tracking-tight { letter-spacing: -0.025em; }
.tracking-wider { letter-spacing: 0.05em; }
.tracking-widest { letter-spacing: 0.1em; }
.text-accent-foreground { color: hsl(var(--accent-foreground)); }
.text-blue-500 { --tw-text-opacity: 1; color: rgb(59 130 246 / var(--tw-text-opacity)); }
.text-blue-600 { --tw-text-opacity: 1; color: rgb(37 99 235 / var(--tw-text-opacity)); }
.text-card-foreground { color: hsl(var(--card-foreground)); }
.text-current { color: currentcolor; }
.text-destructive { color: hsl(var(--destructive)); }
.text-destructive-foreground { color: hsl(var(--destructive-foreground)); }
.text-foreground { color: hsl(var(--foreground)); }
.text-foreground\/50 { color: hsl(var(--foreground) / 0.5); }
.text-gray-500 { --tw-text-opacity: 1; color: rgb(107 114 128 / var(--tw-text-opacity)); }
.text-gray-600 { --tw-text-opacity: 1; color: rgb(75 85 99 / var(--tw-text-opacity)); }
.text-gray-800 { --tw-text-opacity: 1; color: rgb(31 41 55 / var(--tw-text-opacity)); }
.text-gray-900 { --tw-text-opacity: 1; color: rgb(17 24 39 / var(--tw-text-opacity)); }
.text-green-500 { --tw-text-opacity: 1; color: rgb(34 197 94 / var(--tw-text-opacity)); }
.text-green-600 { --tw-text-opacity: 1; color: rgb(22 163 74 / var(--tw-text-opacity)); }
.text-muted-foreground { color: hsl(var(--muted-foreground)); }
.text-orange-500 { --tw-text-opacity: 1; color: rgb(249 115 22 / var(--tw-text-opacity)); }
.text-orange-700 { --tw-text-opacity: 1; color: rgb(194 65 12 / var(--tw-text-opacity)); }
.text-popover-foreground { color: hsl(var(--popover-foreground)); }
.text-primary { color: hsl(var(--primary)); }
.text-primary-foreground { color: hsl(var(--primary-foreground)); }
.text-red-600 { --tw-text-opacity: 1; color: rgb(220 38 38 / var(--tw-text-opacity)); }
.text-red-700 { --tw-text-opacity: 1; color: rgb(185 28 28 / var(--tw-text-opacity)); }
.text-secondary-foreground { color: hsl(var(--secondary-foreground)); }
.text-sidebar-foreground { color: hsl(var(--sidebar-foreground)); }
.text-sidebar-foreground\/70 { color: hsl(var(--sidebar-foreground) / 0.7); }
.text-white { --tw-text-opacity: 1; color: rgb(255 255 255 / var(--tw-text-opacity)); }
.text-yellow-500 { --tw-text-opacity: 1; color: rgb(234 179 8 / var(--tw-text-opacity)); }
.line-through { text-decoration-line: line-through; }
.underline-offset-4 { text-underline-offset: 4px; }
.opacity-0 { opacity: 0; }
.opacity-100 { opacity: 1; }
.opacity-50 { opacity: 0.5; }
.opacity-60 { opacity: 0.6; }
.opacity-70 { opacity: 0.7; }
.opacity-90 { opacity: 0.9; }
.shadow-\[0_0_0_1px_hsl\(var\(--sidebar-border\)\)\] { --tw-shadow: 0 0 0 1px hsl(var(--sidebar-border)); --tw-shadow-colored: 0 0 0 1px var(--tw-shadow-color); box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow); }
.shadow-lg { --tw-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1); --tw-shadow-colored: 0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color); box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow); }
.shadow-md { --tw-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1); --tw-shadow-colored: 0 4px 6px -1px var(--tw-shadow-color), 0 2px 4px -2px var(--tw-shadow-color); box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow); }
.shadow-none { --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow); }
.shadow-sm { --tw-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05); --tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color); box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow); }
.shadow-xl { --tw-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1); --tw-shadow-colored: 0 20px 25px -5px var(--tw-shadow-color), 0 8px 10px -6px var(--tw-shadow-color); box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow); }
.outline-none { outline: transparent solid 2px; outline-offset: 2px; }
.outline { outline-style: solid; }
.ring-0 { --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color); --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(0px + var(--tw-ring-offset-width)) var(--tw-ring-color); box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000); }
.ring-2 { --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color); --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color); box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000); }
.ring-ring { --tw-ring-color: hsl(var(--ring)); }
.ring-sidebar-ring { --tw-ring-color: hsl(var(--sidebar-ring)); }
.ring-offset-background { --tw-ring-offset-color: hsl(var(--background)); }
.filter { filter: var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow); }
.transition { transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter, -webkit-backdrop-filter; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
.transition-\[left\,right\,width\] { transition-property: left, right, width; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
.transition-\[margin\,opa\] { transition-property: margin, opa; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
.transition-\[width\,height\,padding\] { transition-property: width, height, padding; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
.transition-\[width\] { transition-property: width; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
.transition-all { transition-property: all; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
.transition-colors { transition-property: color, background-color, border-color, text-decoration-color, fill, stroke; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
.transition-opacity { transition-property: opacity; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
.transition-shadow { transition-property: box-shadow; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
.transition-transform { transition-property: transform; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
.duration-1000 { transition-duration: 1000ms; }
.duration-200 { transition-duration: 200ms; }
.duration-300 { transition-duration: 300ms; }
.ease-in-out { transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); }
.ease-linear { transition-timing-function: linear; }
@keyframes enter { 
  0% { opacity: var(--tw-enter-opacity, 1); transform: translate3d(var(--tw-enter-translate-x, 0), var(--tw-enter-translate-y, 0), 0) scale3d(var(--tw-enter-scale, 1), var(--tw-enter-scale, 1), var(--tw-enter-scale, 1)) rotate(var(--tw-enter-rotate, 0)); }
}
@keyframes exit { 
  100% { opacity: var(--tw-exit-opacity, 1); transform: translate3d(var(--tw-exit-translate-x, 0), var(--tw-exit-translate-y, 0), 0) scale3d(var(--tw-exit-scale, 1), var(--tw-exit-scale, 1), var(--tw-exit-scale, 1)) rotate(var(--tw-exit-rotate, 0)); }
}
.animate-in { animation-name: enter; animation-duration: 150ms; --tw-enter-opacity: initial; --tw-enter-scale: initial; --tw-enter-rotate: initial; --tw-enter-translate-x: initial; --tw-enter-translate-y: initial; }
.fade-in-0 { --tw-enter-opacity: 0; }
.fade-in-80 { --tw-enter-opacity: 0.8; }
.zoom-in-95 { --tw-enter-scale: .95; }
.duration-1000 { animation-duration: 1000ms; }
.duration-200 { animation-duration: 200ms; }
.duration-300 { animation-duration: 300ms; }
.ease-in-out { animation-timing-function: cubic-bezier(0.4, 0, 0.2, 1); }
.ease-linear { animation-timing-function: linear; }
.glass-panel { background-color: rgba(255, 255, 255, 0.8); --tw-backdrop-blur: blur(12px); backdrop-filter: var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia); }
.glass-panel:is(.dark *) { background-color: rgba(17, 24, 39, 0.8); }
.glass-panel { box-shadow: rgba(0, 0, 0, 0.05) 0px 4px 30px; }
.animate-stagger > * { animation-fill-mode: both; opacity: 0; }
.animate-stagger > :nth-child(1) { animation-delay: 0.1s; }
.animate-stagger > :nth-child(2) { animation-delay: 0.2s; }
.animate-stagger > :nth-child(3) { animation-delay: 0.3s; }
.animate-stagger > :nth-child(4) { animation-delay: 0.4s; }
.animate-stagger > :nth-child(5) { animation-delay: 0.5s; }
.animate-stagger > :nth-child(6) { animation-delay: 0.6s; }
.animate-stagger > :nth-child(7) { animation-delay: 0.7s; }
.animate-stagger > :nth-child(8) { animation-delay: 0.8s; }
.animate-stagger > :nth-child(9) { animation-delay: 0.9s; }
.animate-stagger > :nth-child(10) { animation-delay: 1s; }
@keyframes float { 
  0% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
  100% { transform: translateY(0px); }
}
.animate-float { animation: 6s ease-in-out 0s infinite normal none running float; }
@keyframes pulse-subtle { 
  0% { opacity: 0.8; }
  50% { opacity: 1; }
  100% { opacity: 0.8; }
}
.animate-pulse-subtle { animation: 3s ease-in-out 0s infinite normal none running pulse-subtle; }
.file\:border-0::file-selector-button { border-width: 0px; }
.file\:bg-transparent::file-selector-button { background-color: transparent; }
.file\:text-sm::file-selector-button { font-size: 0.875rem; line-height: 1.25rem; }
.file\:font-medium::file-selector-button { font-weight: 500; }
.file\:text-foreground::file-selector-button { color: hsl(var(--foreground)); }
.placeholder\:text-muted-foreground::placeholder { color: hsl(var(--muted-foreground)); }
.after\:absolute::after { content: var(--tw-content); position: absolute; }
.after\:-inset-2::after { content: var(--tw-content); inset: -0.5rem; }
.after\:inset-y-0::after { content: var(--tw-content); top: 0px; bottom: 0px; }
.after\:left-1\/2::after { content: var(--tw-content); left: 50%; }
.after\:w-1::after { content: var(--tw-content); width: 0.25rem; }
.after\:w-\[2px\]::after { content: var(--tw-content); width: 2px; }
.after\:-translate-x-1\/2::after { content: var(--tw-content); --tw-translate-x: -50%; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.first\:rounded-l-md:first-child { border-top-left-radius: calc(var(--radius) - 2px); border-bottom-left-radius: calc(var(--radius) - 2px); }
.first\:border-l:first-child { border-left-width: 1px; }
.last\:rounded-r-md:last-child { border-top-right-radius: calc(var(--radius) - 2px); border-bottom-right-radius: calc(var(--radius) - 2px); }
.focus-within\:relative:focus-within { position: relative; }
.focus-within\:z-20:focus-within { z-index: 20; }
.hover\:translate-x-\[-4px\]:hover { --tw-translate-x: -4px; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.hover\:border-blue-200:hover { --tw-border-opacity: 1; border-color: rgb(191 219 254 / var(--tw-border-opacity)); }
.hover\:border-primary\/70:hover { border-color: hsl(var(--primary) / 0.7); }
.hover\:bg-accent:hover { background-color: hsl(var(--accent)); }
.hover\:bg-blue-50:hover { --tw-bg-opacity: 1; background-color: rgb(239 246 255 / var(--tw-bg-opacity)); }
.hover\:bg-destructive\/80:hover { background-color: hsl(var(--destructive) / 0.8); }
.hover\:bg-destructive\/90:hover { background-color: hsl(var(--destructive) / 0.9); }
.hover\:bg-gray-50:hover { --tw-bg-opacity: 1; background-color: rgb(249 250 251 / var(--tw-bg-opacity)); }
.hover\:bg-muted:hover { background-color: hsl(var(--muted)); }
.hover\:bg-muted\/50:hover { background-color: hsl(var(--muted) / 0.5); }
.hover\:bg-primary:hover { background-color: hsl(var(--primary)); }
.hover\:bg-primary\/80:hover { background-color: hsl(var(--primary) / 0.8); }
.hover\:bg-primary\/90:hover { background-color: hsl(var(--primary) / 0.9); }
.hover\:bg-secondary:hover { background-color: hsl(var(--secondary)); }
.hover\:bg-secondary\/80:hover { background-color: hsl(var(--secondary) / 0.8); }
.hover\:bg-sidebar-accent:hover { background-color: hsl(var(--sidebar-accent)); }
.hover\:text-accent-foreground:hover { color: hsl(var(--accent-foreground)); }
.hover\:text-foreground:hover { color: hsl(var(--foreground)); }
.hover\:text-muted-foreground:hover { color: hsl(var(--muted-foreground)); }
.hover\:text-primary-foreground:hover { color: hsl(var(--primary-foreground)); }
.hover\:text-sidebar-accent-foreground:hover { color: hsl(var(--sidebar-accent-foreground)); }
.hover\:underline:hover { text-decoration-line: underline; }
.hover\:opacity-100:hover { opacity: 1; }
.hover\:shadow-\[0_0_0_1px_hsl\(var\(--sidebar-accent\)\)\]:hover { --tw-shadow: 0 0 0 1px hsl(var(--sidebar-accent)); --tw-shadow-colored: 0 0 0 1px var(--tw-shadow-color); box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow); }
.hover\:shadow-md:hover { --tw-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1); --tw-shadow-colored: 0 4px 6px -1px var(--tw-shadow-color), 0 2px 4px -2px var(--tw-shadow-color); box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow); }
.hover\:after\:bg-sidebar-border:hover::after { content: var(--tw-content); background-color: hsl(var(--sidebar-border)); }
.focus\:bg-accent:focus { background-color: hsl(var(--accent)); }
.focus\:bg-primary:focus { background-color: hsl(var(--primary)); }
.focus\:text-accent-foreground:focus { color: hsl(var(--accent-foreground)); }
.focus\:text-primary-foreground:focus { color: hsl(var(--primary-foreground)); }
.focus\:opacity-100:focus { opacity: 1; }
.focus\:outline-none:focus { outline: transparent solid 2px; outline-offset: 2px; }
.focus\:ring-2:focus { --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color); --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color); box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000); }
.focus\:ring-ring:focus { --tw-ring-color: hsl(var(--ring)); }
.focus\:ring-offset-2:focus { --tw-ring-offset-width: 2px; }
.focus-visible\:outline-none:focus-visible { outline: transparent solid 2px; outline-offset: 2px; }
.focus-visible\:ring-1:focus-visible { --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color); --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color); box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000); }
.focus-visible\:ring-2:focus-visible { --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color); --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color); box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000); }
.focus-visible\:ring-ring:focus-visible { --tw-ring-color: hsl(var(--ring)); }
.focus-visible\:ring-sidebar-ring:focus-visible { --tw-ring-color: hsl(var(--sidebar-ring)); }
.focus-visible\:ring-offset-1:focus-visible { --tw-ring-offset-width: 1px; }
.focus-visible\:ring-offset-2:focus-visible { --tw-ring-offset-width: 2px; }
.focus-visible\:ring-offset-background:focus-visible { --tw-ring-offset-color: hsl(var(--background)); }
.active\:bg-sidebar-accent:active { background-color: hsl(var(--sidebar-accent)); }
.active\:text-sidebar-accent-foreground:active { color: hsl(var(--sidebar-accent-foreground)); }
.disabled\:pointer-events-none:disabled { pointer-events: none; }
.disabled\:cursor-not-allowed:disabled { cursor: not-allowed; }
.disabled\:opacity-50:disabled { opacity: 0.5; }
.group\/menu-item:focus-within .group-focus-within\/menu-item\:opacity-100 { opacity: 1; }
.group\/menu-item:hover .group-hover\/menu-item\:opacity-100 { opacity: 1; }
.group:hover .group-hover\:opacity-100 { opacity: 1; }
.group.destructive .group-\[\.destructive\]\:border-muted\/40 { border-color: hsl(var(--muted) / 0.4); }
.group.toaster .group-\[\.toaster\]\:border-border { border-color: hsl(var(--border)); }
.group.toast .group-\[\.toast\]\:bg-muted { background-color: hsl(var(--muted)); }
.group.toast .group-\[\.toast\]\:bg-primary { background-color: hsl(var(--primary)); }
.group.toaster .group-\[\.toaster\]\:bg-background { background-color: hsl(var(--background)); }
.group.destructive .group-\[\.destructive\]\:text-red-300 { --tw-text-opacity: 1; color: rgb(252 165 165 / var(--tw-text-opacity)); }
.group.toast .group-\[\.toast\]\:text-muted-foreground { color: hsl(var(--muted-foreground)); }
.group.toast .group-\[\.toast\]\:text-primary-foreground { color: hsl(var(--primary-foreground)); }
.group.toaster .group-\[\.toaster\]\:text-foreground { color: hsl(var(--foreground)); }
.group.toaster .group-\[\.toaster\]\:shadow-lg { --tw-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1); --tw-shadow-colored: 0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color); box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow); }
.group.destructive .group-\[\.destructive\]\:hover\:border-destructive\/30:hover { border-color: hsl(var(--destructive) / 0.3); }
.group.destructive .group-\[\.destructive\]\:hover\:bg-destructive:hover { background-color: hsl(var(--destructive)); }
.group.destructive .group-\[\.destructive\]\:hover\:text-destructive-foreground:hover { color: hsl(var(--destructive-foreground)); }
.group.destructive .group-\[\.destructive\]\:hover\:text-red-50:hover { --tw-text-opacity: 1; color: rgb(254 242 242 / var(--tw-text-opacity)); }
.group.destructive .group-\[\.destructive\]\:focus\:ring-destructive:focus { --tw-ring-color: hsl(var(--destructive)); }
.group.destructive .group-\[\.destructive\]\:focus\:ring-red-400:focus { --tw-ring-opacity: 1; --tw-ring-color: rgb(248 113 113 / var(--tw-ring-opacity)); }
.group.destructive .group-\[\.destructive\]\:focus\:ring-offset-red-600:focus { --tw-ring-offset-color: #dc2626; }
.peer\/menu-button:hover ~ .peer-hover\/menu-button\:text-sidebar-accent-foreground { color: hsl(var(--sidebar-accent-foreground)); }
.peer:disabled ~ .peer-disabled\:cursor-not-allowed { cursor: not-allowed; }
.peer:disabled ~ .peer-disabled\:opacity-70 { opacity: 0.7; }
.has-\[\[data-variant\=inset\]\]\:bg-sidebar:has([data-variant="inset"]) { background-color: hsl(var(--sidebar-background)); }
.has-\[\:disabled\]\:opacity-50:has(:disabled) { opacity: 0.5; }
.group\/menu-item:has([data-sidebar="menu-action"]) .group-has-\[\[data-sidebar\=menu-action\]\]\/menu-item\:pr-8 { padding-right: 2rem; }
.aria-disabled\:pointer-events-none[aria-disabled="true"] { pointer-events: none; }
.aria-disabled\:opacity-50[aria-disabled="true"] { opacity: 0.5; }
.aria-selected\:bg-accent[aria-selected="true"] { background-color: hsl(var(--accent)); }
.aria-selected\:bg-accent\/50[aria-selected="true"] { background-color: hsl(var(--accent) / 0.5); }
.aria-selected\:text-accent-foreground[aria-selected="true"] { color: hsl(var(--accent-foreground)); }
.aria-selected\:text-muted-foreground[aria-selected="true"] { color: hsl(var(--muted-foreground)); }
.aria-selected\:opacity-100[aria-selected="true"] { opacity: 1; }
.aria-selected\:opacity-30[aria-selected="true"] { opacity: 0.3; }
.data-\[disabled\=true\]\:pointer-events-none[data-disabled="true"] { pointer-events: none; }
.data-\[disabled\]\:pointer-events-none[data-disabled] { pointer-events: none; }
.data-\[panel-group-direction\=vertical\]\:h-px[data-panel-group-direction="vertical"] { height: 1px; }
.data-\[panel-group-direction\=vertical\]\:w-full[data-panel-group-direction="vertical"] { width: 100%; }
.data-\[side\=bottom\]\:translate-y-1[data-side="bottom"] { --tw-translate-y: 0.25rem; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.data-\[side\=left\]\:-translate-x-1[data-side="left"] { --tw-translate-x: -0.25rem; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.data-\[side\=right\]\:translate-x-1[data-side="right"] { --tw-translate-x: 0.25rem; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.data-\[side\=top\]\:-translate-y-1[data-side="top"] { --tw-translate-y: -0.25rem; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.data-\[state\=checked\]\:translate-x-5[data-state="checked"] { --tw-translate-x: 1.25rem; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.data-\[state\=unchecked\]\:translate-x-0[data-state="unchecked"] { --tw-translate-x: 0px; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.data-\[swipe\=cancel\]\:translate-x-0[data-swipe="cancel"] { --tw-translate-x: 0px; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.data-\[swipe\=end\]\:translate-x-\[var\(--radix-toast-swipe-end-x\)\][data-swipe="end"] { --tw-translate-x: var(--radix-toast-swipe-end-x); transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.data-\[swipe\=move\]\:translate-x-\[var\(--radix-toast-swipe-move-x\)\][data-swipe="move"] { --tw-translate-x: var(--radix-toast-swipe-move-x); transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
@keyframes accordion-up { 
  0% { height: var(--radix-accordion-content-height); }
  100% { height: 0px; }
}
.data-\[state\=closed\]\:animate-accordion-up[data-state="closed"] { animation: 0.2s ease-out 0s 1 normal none running accordion-up; }
@keyframes accordion-down { 
  0% { height: 0px; }
  100% { height: var(--radix-accordion-content-height); }
}
.data-\[state\=open\]\:animate-accordion-down[data-state="open"] { animation: 0.2s ease-out 0s 1 normal none running accordion-down; }
.data-\[panel-group-direction\=vertical\]\:flex-col[data-panel-group-direction="vertical"] { flex-direction: column; }
.data-\[active\=true\]\:bg-sidebar-accent[data-active="true"] { background-color: hsl(var(--sidebar-accent)); }
.data-\[active\]\:bg-accent\/50[data-active] { background-color: hsl(var(--accent) / 0.5); }
.data-\[selected\=\'true\'\]\:bg-accent[data-selected="true"] { background-color: hsl(var(--accent)); }
.data-\[state\=active\]\:bg-background[data-state="active"] { background-color: hsl(var(--background)); }
.data-\[state\=checked\]\:bg-primary[data-state="checked"] { background-color: hsl(var(--primary)); }
.data-\[state\=on\]\:bg-accent[data-state="on"] { background-color: hsl(var(--accent)); }
.data-\[state\=open\]\:bg-accent[data-state="open"] { background-color: hsl(var(--accent)); }
.data-\[state\=open\]\:bg-accent\/50[data-state="open"] { background-color: hsl(var(--accent) / 0.5); }
.data-\[state\=open\]\:bg-secondary[data-state="open"] { background-color: hsl(var(--secondary)); }
.data-\[state\=selected\]\:bg-muted[data-state="selected"] { background-color: hsl(var(--muted)); }
.data-\[state\=unchecked\]\:bg-input[data-state="unchecked"] { background-color: hsl(var(--input)); }
.data-\[active\=true\]\:font-medium[data-active="true"] { font-weight: 500; }
.data-\[active\=true\]\:text-sidebar-accent-foreground[data-active="true"] { color: hsl(var(--sidebar-accent-foreground)); }
.data-\[selected\=true\]\:text-accent-foreground[data-selected="true"] { color: hsl(var(--accent-foreground)); }
.data-\[state\=active\]\:text-foreground[data-state="active"] { color: hsl(var(--foreground)); }
.data-\[state\=checked\]\:text-primary-foreground[data-state="checked"] { color: hsl(var(--primary-foreground)); }
.data-\[state\=on\]\:text-accent-foreground[data-state="on"] { color: hsl(var(--accent-foreground)); }
.data-\[state\=open\]\:text-accent-foreground[data-state="open"] { color: hsl(var(--accent-foreground)); }
.data-\[state\=open\]\:text-muted-foreground[data-state="open"] { color: hsl(var(--muted-foreground)); }
.data-\[disabled\=true\]\:opacity-50[data-disabled="true"] { opacity: 0.5; }
.data-\[disabled\]\:opacity-50[data-disabled] { opacity: 0.5; }
.data-\[state\=open\]\:opacity-100[data-state="open"] { opacity: 1; }
.data-\[state\=active\]\:shadow-sm[data-state="active"] { --tw-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05); --tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color); box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow); }
.data-\[swipe\=move\]\:transition-none[data-swipe="move"] { transition-property: none; }
.data-\[state\=closed\]\:duration-300[data-state="closed"] { transition-duration: 300ms; }
.data-\[state\=open\]\:duration-500[data-state="open"] { transition-duration: 500ms; }
.data-\[motion\^\=from-\]\:animate-in[data-motion^="from-"] { animation-name: enter; animation-duration: 150ms; --tw-enter-opacity: initial; --tw-enter-scale: initial; --tw-enter-rotate: initial; --tw-enter-translate-x: initial; --tw-enter-translate-y: initial; }
.data-\[state\=open\]\:animate-in[data-state="open"] { animation-name: enter; animation-duration: 150ms; --tw-enter-opacity: initial; --tw-enter-scale: initial; --tw-enter-rotate: initial; --tw-enter-translate-x: initial; --tw-enter-translate-y: initial; }
.data-\[state\=visible\]\:animate-in[data-state="visible"] { animation-name: enter; animation-duration: 150ms; --tw-enter-opacity: initial; --tw-enter-scale: initial; --tw-enter-rotate: initial; --tw-enter-translate-x: initial; --tw-enter-translate-y: initial; }
.data-\[motion\^\=to-\]\:animate-out[data-motion^="to-"] { animation-name: exit; animation-duration: 150ms; --tw-exit-opacity: initial; --tw-exit-scale: initial; --tw-exit-rotate: initial; --tw-exit-translate-x: initial; --tw-exit-translate-y: initial; }
.data-\[state\=closed\]\:animate-out[data-state="closed"] { animation-name: exit; animation-duration: 150ms; --tw-exit-opacity: initial; --tw-exit-scale: initial; --tw-exit-rotate: initial; --tw-exit-translate-x: initial; --tw-exit-translate-y: initial; }
.data-\[state\=hidden\]\:animate-out[data-state="hidden"] { animation-name: exit; animation-duration: 150ms; --tw-exit-opacity: initial; --tw-exit-scale: initial; --tw-exit-rotate: initial; --tw-exit-translate-x: initial; --tw-exit-translate-y: initial; }
.data-\[swipe\=end\]\:animate-out[data-swipe="end"] { animation-name: exit; animation-duration: 150ms; --tw-exit-opacity: initial; --tw-exit-scale: initial; --tw-exit-rotate: initial; --tw-exit-translate-x: initial; --tw-exit-translate-y: initial; }
.data-\[motion\^\=from-\]\:fade-in[data-motion^="from-"] { --tw-enter-opacity: 0; }
.data-\[motion\^\=to-\]\:fade-out[data-motion^="to-"] { --tw-exit-opacity: 0; }
.data-\[state\=closed\]\:fade-out-0[data-state="closed"] { --tw-exit-opacity: 0; }
.data-\[state\=closed\]\:fade-out-80[data-state="closed"] { --tw-exit-opacity: 0.8; }
.data-\[state\=hidden\]\:fade-out[data-state="hidden"] { --tw-exit-opacity: 0; }
.data-\[state\=open\]\:fade-in-0[data-state="open"] { --tw-enter-opacity: 0; }
.data-\[state\=visible\]\:fade-in[data-state="visible"] { --tw-enter-opacity: 0; }
.data-\[state\=closed\]\:zoom-out-95[data-state="closed"] { --tw-exit-scale: .95; }
.data-\[state\=open\]\:zoom-in-90[data-state="open"] { --tw-enter-scale: .9; }
.data-\[state\=open\]\:zoom-in-95[data-state="open"] { --tw-enter-scale: .95; }
.data-\[motion\=from-end\]\:slide-in-from-right-52[data-motion="from-end"] { --tw-enter-translate-x: 13rem; }
.data-\[motion\=from-start\]\:slide-in-from-left-52[data-motion="from-start"] { --tw-enter-translate-x: -13rem; }
.data-\[motion\=to-end\]\:slide-out-to-right-52[data-motion="to-end"] { --tw-exit-translate-x: 13rem; }
.data-\[motion\=to-start\]\:slide-out-to-left-52[data-motion="to-start"] { --tw-exit-translate-x: -13rem; }
.data-\[side\=bottom\]\:slide-in-from-top-2[data-side="bottom"] { --tw-enter-translate-y: -0.5rem; }
.data-\[side\=left\]\:slide-in-from-right-2[data-side="left"] { --tw-enter-translate-x: 0.5rem; }
.data-\[side\=right\]\:slide-in-from-left-2[data-side="right"] { --tw-enter-translate-x: -0.5rem; }
.data-\[side\=top\]\:slide-in-from-bottom-2[data-side="top"] { --tw-enter-translate-y: 0.5rem; }
.data-\[state\=closed\]\:slide-out-to-bottom[data-state="closed"] { --tw-exit-translate-y: 100%; }
.data-\[state\=closed\]\:slide-out-to-left[data-state="closed"] { --tw-exit-translate-x: -100%; }
.data-\[state\=closed\]\:slide-out-to-left-1\/2[data-state="closed"] { --tw-exit-translate-x: -50%; }
.data-\[state\=closed\]\:slide-out-to-right[data-state="closed"] { --tw-exit-translate-x: 100%; }
.data-\[state\=closed\]\:slide-out-to-right-full[data-state="closed"] { --tw-exit-translate-x: 100%; }
.data-\[state\=closed\]\:slide-out-to-top[data-state="closed"] { --tw-exit-translate-y: -100%; }
.data-\[state\=closed\]\:slide-out-to-top-\[48\%\][data-state="closed"] { --tw-exit-translate-y: -48%; }
.data-\[state\=open\]\:slide-in-from-bottom[data-state="open"] { --tw-enter-translate-y: 100%; }
.data-\[state\=open\]\:slide-in-from-left[data-state="open"] { --tw-enter-translate-x: -100%; }
.data-\[state\=open\]\:slide-in-from-left-1\/2[data-state="open"] { --tw-enter-translate-x: -50%; }
.data-\[state\=open\]\:slide-in-from-right[data-state="open"] { --tw-enter-translate-x: 100%; }
.data-\[state\=open\]\:slide-in-from-top[data-state="open"] { --tw-enter-translate-y: -100%; }
.data-\[state\=open\]\:slide-in-from-top-\[48\%\][data-state="open"] { --tw-enter-translate-y: -48%; }
.data-\[state\=open\]\:slide-in-from-top-full[data-state="open"] { --tw-enter-translate-y: -100%; }
.data-\[state\=closed\]\:duration-300[data-state="closed"] { animation-duration: 300ms; }
.data-\[state\=open\]\:duration-500[data-state="open"] { animation-duration: 500ms; }
.data-\[panel-group-direction\=vertical\]\:after\:left-0[data-panel-group-direction="vertical"]::after { content: var(--tw-content); left: 0px; }
.data-\[panel-group-direction\=vertical\]\:after\:h-1[data-panel-group-direction="vertical"]::after { content: var(--tw-content); height: 0.25rem; }
.data-\[panel-group-direction\=vertical\]\:after\:w-full[data-panel-group-direction="vertical"]::after { content: var(--tw-content); width: 100%; }
.data-\[panel-group-direction\=vertical\]\:after\:-translate-y-1\/2[data-panel-group-direction="vertical"]::after { content: var(--tw-content); --tw-translate-y: -50%; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.data-\[panel-group-direction\=vertical\]\:after\:translate-x-0[data-panel-group-direction="vertical"]::after { content: var(--tw-content); --tw-translate-x: 0px; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.data-\[state\=open\]\:hover\:bg-sidebar-accent:hover[data-state="open"] { background-color: hsl(var(--sidebar-accent)); }
.data-\[state\=open\]\:hover\:text-sidebar-accent-foreground:hover[data-state="open"] { color: hsl(var(--sidebar-accent-foreground)); }
.group[data-collapsible="offcanvas"] .group-data-\[collapsible\=offcanvas\]\:left-\[calc\(var\(--sidebar-width\)\*-1\)\] { left: calc(var(--sidebar-width) * -1); }
.group[data-collapsible="offcanvas"] .group-data-\[collapsible\=offcanvas\]\:right-\[calc\(var\(--sidebar-width\)\*-1\)\] { right: calc(var(--sidebar-width) * -1); }
.group[data-side="left"] .group-data-\[side\=left\]\:-right-4 { right: -1rem; }
.group[data-side="right"] .group-data-\[side\=right\]\:left-0 { left: 0px; }
.group[data-collapsible="icon"] .group-data-\[collapsible\=icon\]\:-mt-8 { margin-top: -2rem; }
.group[data-collapsible="icon"] .group-data-\[collapsible\=icon\]\:hidden { display: none; }
.group[data-collapsible="icon"] .group-data-\[collapsible\=icon\]\:\!size-8 { width: 2rem !important; height: 2rem !important; }
.group[data-collapsible="icon"] .group-data-\[collapsible\=icon\]\:w-\[--sidebar-width-icon\] { width: var(--sidebar-width-icon); }
.group[data-collapsible="icon"] .group-data-\[collapsible\=icon\]\:w-\[calc\(var\(--sidebar-width-icon\)_\+_theme\(spacing\.4\)\)\] { width: calc(var(--sidebar-width-icon) + 1rem); }
.group[data-collapsible="icon"] .group-data-\[collapsible\=icon\]\:w-\[calc\(var\(--sidebar-width-icon\)_\+_theme\(spacing\.4\)_\+2px\)\] { width: calc(var(--sidebar-width-icon) + 1rem + 2px); }
.group[data-collapsible="offcanvas"] .group-data-\[collapsible\=offcanvas\]\:w-0 { width: 0px; }
.group[data-collapsible="offcanvas"] .group-data-\[collapsible\=offcanvas\]\:translate-x-0 { --tw-translate-x: 0px; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.group[data-side="right"] .group-data-\[side\=right\]\:rotate-180 { --tw-rotate: 180deg; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.group[data-state="open"] .group-data-\[state\=open\]\:rotate-180 { --tw-rotate: 180deg; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.group[data-collapsible="icon"] .group-data-\[collapsible\=icon\]\:overflow-hidden { overflow: hidden; }
.group[data-variant="floating"] .group-data-\[variant\=floating\]\:rounded-lg { border-radius: var(--radius); }
.group[data-variant="floating"] .group-data-\[variant\=floating\]\:border { border-width: 1px; }
.group[data-side="left"] .group-data-\[side\=left\]\:border-r { border-right-width: 1px; }
.group[data-side="right"] .group-data-\[side\=right\]\:border-l { border-left-width: 1px; }
.group[data-variant="floating"] .group-data-\[variant\=floating\]\:border-sidebar-border { border-color: hsl(var(--sidebar-border)); }
.group[data-collapsible="icon"] .group-data-\[collapsible\=icon\]\:\!p-0 { padding: 0px !important; }
.group[data-collapsible="icon"] .group-data-\[collapsible\=icon\]\:\!p-2 { padding: 0.5rem !important; }
.group[data-collapsible="icon"] .group-data-\[collapsible\=icon\]\:opacity-0 { opacity: 0; }
.group[data-variant="floating"] .group-data-\[variant\=floating\]\:shadow { --tw-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1); --tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color); box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow); }
.group[data-collapsible="offcanvas"] .group-data-\[collapsible\=offcanvas\]\:after\:left-full::after { content: var(--tw-content); left: 100%; }
.group[data-collapsible="offcanvas"] .group-data-\[collapsible\=offcanvas\]\:hover\:bg-sidebar:hover { background-color: hsl(var(--sidebar-background)); }
.peer\/menu-button[data-size="default"] ~ .peer-data-\[size\=default\]\/menu-button\:top-1\.5 { top: 0.375rem; }
.peer\/menu-button[data-size="lg"] ~ .peer-data-\[size\=lg\]\/menu-button\:top-2\.5 { top: 0.625rem; }
.peer\/menu-button[data-size="sm"] ~ .peer-data-\[size\=sm\]\/menu-button\:top-1 { top: 0.25rem; }
.peer[data-variant="inset"] ~ .peer-data-\[variant\=inset\]\:min-h-\[calc\(100svh-theme\(spacing\.4\)\)\] { min-height: calc(-1rem + 100svh); }
.peer\/menu-button[data-active="true"] ~ .peer-data-\[active\=true\]\/menu-button\:text-sidebar-accent-foreground { color: hsl(var(--sidebar-accent-foreground)); }
.dark\:border-destructive:is(.dark *) { border-color: hsl(var(--destructive)); }
@media (min-width: 640px) {
  .sm\:bottom-0 { bottom: 0px; }
  .sm\:right-0 { right: 0px; }
  .sm\:top-auto { top: auto; }
  .sm\:mt-0 { margin-top: 0px; }
  .sm\:flex { display: flex; }
  .sm\:max-w-sm { max-width: 24rem; }
  .sm\:flex-row { flex-direction: row; }
  .sm\:flex-col { flex-direction: column; }
  .sm\:justify-end { justify-content: flex-end; }
  .sm\:gap-2\.5 { gap: 0.625rem; }
  .sm\:space-x-2 > :not([hidden]) ~ :not([hidden]) { --tw-space-x-reverse: 0; margin-right: calc(0.5rem * var(--tw-space-x-reverse)); margin-left: calc(0.5rem * calc(1 - var(--tw-space-x-reverse))); }
  .sm\:space-x-4 > :not([hidden]) ~ :not([hidden]) { --tw-space-x-reverse: 0; margin-right: calc(1rem * var(--tw-space-x-reverse)); margin-left: calc(1rem * calc(1 - var(--tw-space-x-reverse))); }
  .sm\:space-y-0 > :not([hidden]) ~ :not([hidden]) { --tw-space-y-reverse: 0; margin-top: calc(0px * calc(1 - var(--tw-space-y-reverse))); margin-bottom: calc(0px * var(--tw-space-y-reverse)); }
  .sm\:rounded-lg { border-radius: var(--radius); }
  .sm\:text-left { text-align: left; }
  .data-\[state\=open\]\:sm\:slide-in-from-bottom-full[data-state="open"] { --tw-enter-translate-y: 100%; }
}
@media (min-width: 768px) {
  .md\:absolute { position: absolute; }
  .md\:block { display: block; }
  .md\:flex { display: flex; }
  .md\:w-\[var\(--radix-navigation-menu-viewport-width\)\] { width: var(--radix-navigation-menu-viewport-width); }
  .md\:w-auto { width: auto; }
  .md\:max-w-\[420px\] { max-width: 420px; }
  .md\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0px, 1fr)); }
  .md\:py-12 { padding-top: 3rem; padding-bottom: 3rem; }
  .md\:text-sm { font-size: 0.875rem; line-height: 1.25rem; }
  .md\:opacity-0 { opacity: 0; }
  .after\:md\:hidden::after { content: var(--tw-content); display: none; }
  .peer[data-variant="inset"] ~ .md\:peer-data-\[variant\=inset\]\:m-2 { margin: 0.5rem; }
  .peer[data-state="collapsed"][data-variant="inset"] ~ .md\:peer-data-\[state\=collapsed\]\:peer-data-\[variant\=inset\]\:ml-2 { margin-left: 0.5rem; }
  .peer[data-variant="inset"] ~ .md\:peer-data-\[variant\=inset\]\:ml-0 { margin-left: 0px; }
  .peer[data-variant="inset"] ~ .md\:peer-data-\[variant\=inset\]\:rounded-xl { border-radius: 0.75rem; }
  .peer[data-variant="inset"] ~ .md\:peer-data-\[variant\=inset\]\:shadow { --tw-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1); --tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color); box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow); }
}
.\[\&\:has\(\[aria-selected\]\)\]\:bg-accent:has([aria-selected]) { background-color: hsl(var(--accent)); }
.first\:\[\&\:has\(\[aria-selected\]\)\]\:rounded-l-md:has([aria-selected]):first-child { border-top-left-radius: calc(var(--radius) - 2px); border-bottom-left-radius: calc(var(--radius) - 2px); }
.last\:\[\&\:has\(\[aria-selected\]\)\]\:rounded-r-md:has([aria-selected]):last-child { border-top-right-radius: calc(var(--radius) - 2px); border-bottom-right-radius: calc(var(--radius) - 2px); }
.\[\&\:has\(\[aria-selected\]\.day-outside\)\]\:bg-accent\/50:has([aria-selected].day-outside) { background-color: hsl(var(--accent) / 0.5); }
.\[\&\:has\(\[aria-selected\]\.day-range-end\)\]\:rounded-r-md:has([aria-selected].day-range-end) { border-top-right-radius: calc(var(--radius) - 2px); border-bottom-right-radius: calc(var(--radius) - 2px); }
.\[\&\:has\(\[role\=checkbox\]\)\]\:pr-0:has([role="checkbox"]) { padding-right: 0px; }
.\[\&\>button\]\:hidden > button { display: none; }
.\[\&\>span\:last-child\]\:truncate > span:last-child { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.\[\&\>span\]\:line-clamp-1 > span { overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 1; }
.\[\&\>svg\+div\]\:translate-y-\[-3px\] > svg + div { --tw-translate-y: -3px; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.\[\&\>svg\]\:absolute > svg { position: absolute; }
.\[\&\>svg\]\:left-4 > svg { left: 1rem; }
.\[\&\>svg\]\:top-4 > svg { top: 1rem; }
.\[\&\>svg\]\:size-3\.5 > svg { width: 0.875rem; height: 0.875rem; }
.\[\&\>svg\]\:size-4 > svg { width: 1rem; height: 1rem; }
.\[\&\>svg\]\:h-2\.5 > svg { height: 0.625rem; }
.\[\&\>svg\]\:h-3 > svg { height: 0.75rem; }
.\[\&\>svg\]\:w-2\.5 > svg { width: 0.625rem; }
.\[\&\>svg\]\:w-3 > svg { width: 0.75rem; }
.\[\&\>svg\]\:shrink-0 > svg { flex-shrink: 0; }
.\[\&\>svg\]\:text-destructive > svg { color: hsl(var(--destructive)); }
.\[\&\>svg\]\:text-foreground > svg { color: hsl(var(--foreground)); }
.\[\&\>svg\]\:text-muted-foreground > svg { color: hsl(var(--muted-foreground)); }
.\[\&\>svg\]\:text-sidebar-accent-foreground > svg { color: hsl(var(--sidebar-accent-foreground)); }
.\[\&\>svg\~\*\]\:pl-7 > svg ~ * { padding-left: 1.75rem; }
.\[\&\>tr\]\:last\:border-b-0:last-child > tr { border-bottom-width: 0px; }
.\[\&\[data-panel-group-direction\=vertical\]\>div\]\:rotate-90[data-panel-group-direction="vertical"] > div { --tw-rotate: 90deg; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.\[\&\[data-state\=open\]\>svg\]\:rotate-180[data-state="open"] > svg { --tw-rotate: 180deg; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
.\[\&_\.recharts-cartesian-axis-tick_text\]\:fill-muted-foreground .recharts-cartesian-axis-tick text { fill: hsl(var(--muted-foreground)); }
.\[\&_\.recharts-cartesian-grid_line\[stroke\=\'\#ccc\'\]\]\:stroke-border\/50 .recharts-cartesian-grid line[stroke="#ccc"] { stroke: hsl(var(--border) / 0.5); }
.\[\&_\.recharts-curve\.recharts-tooltip-cursor\]\:stroke-border .recharts-curve.recharts-tooltip-cursor { stroke: hsl(var(--border)); }
.\[\&_\.recharts-dot\[stroke\=\'\#fff\'\]\]\:stroke-transparent .recharts-dot[stroke="#fff"] { stroke: transparent; }
.\[\&_\.recharts-layer\]\:outline-none .recharts-layer { outline: transparent solid 2px; outline-offset: 2px; }
.\[\&_\.recharts-polar-grid_\[stroke\=\'\#ccc\'\]\]\:stroke-border .recharts-polar-grid [stroke="#ccc"] { stroke: hsl(var(--border)); }
.\[\&_\.recharts-radial-bar-background-sector\]\:fill-muted .recharts-radial-bar-background-sector { fill: hsl(var(--muted)); }
.\[\&_\.recharts-rectangle\.recharts-tooltip-cursor\]\:fill-muted .recharts-rectangle.recharts-tooltip-cursor { fill: hsl(var(--muted)); }
.\[\&_\.recharts-reference-line_\[stroke\=\'\#ccc\'\]\]\:stroke-border .recharts-reference-line [stroke="#ccc"] { stroke: hsl(var(--border)); }
.\[\&_\.recharts-sector\[stroke\=\'\#fff\'\]\]\:stroke-transparent .recharts-sector[stroke="#fff"] { stroke: transparent; }
.\[\&_\.recharts-sector\]\:outline-none .recharts-sector { outline: transparent solid 2px; outline-offset: 2px; }
.\[\&_\.recharts-surface\]\:outline-none .recharts-surface { outline: transparent solid 2px; outline-offset: 2px; }
.\[\&_\[cmdk-group-heading\]\]\:px-2 [cmdk-group-heading] { padding-left: 0.5rem; padding-right: 0.5rem; }
.\[\&_\[cmdk-group-heading\]\]\:py-1\.5 [cmdk-group-heading] { padding-top: 0.375rem; padding-bottom: 0.375rem; }
.\[\&_\[cmdk-group-heading\]\]\:text-xs [cmdk-group-heading] { font-size: 0.75rem; line-height: 1rem; }
.\[\&_\[cmdk-group-heading\]\]\:font-medium [cmdk-group-heading] { font-weight: 500; }
.\[\&_\[cmdk-group-heading\]\]\:text-muted-foreground [cmdk-group-heading] { color: hsl(var(--muted-foreground)); }
.\[\&_\[cmdk-group\]\:not\(\[hidden\]\)_\~\[cmdk-group\]\]\:pt-0 [cmdk-group]:not([hidden]) ~ [cmdk-group] { padding-top: 0px; }
.\[\&_\[cmdk-group\]\]\:px-2 [cmdk-group] { padding-left: 0.5rem; padding-right: 0.5rem; }
.\[\&_\[cmdk-input-wrapper\]_svg\]\:h-5 [cmdk-input-wrapper] svg { height: 1.25rem; }
.\[\&_\[cmdk-input-wrapper\]_svg\]\:w-5 [cmdk-input-wrapper] svg { width: 1.25rem; }
.\[\&_\[cmdk-input\]\]\:h-12 [cmdk-input] { height: 3rem; }
.\[\&_\[cmdk-item\]\]\:px-2 [cmdk-item] { padding-left: 0.5rem; padding-right: 0.5rem; }
.\[\&_\[cmdk-item\]\]\:py-3 [cmdk-item] { padding-top: 0.75rem; padding-bottom: 0.75rem; }
.\[\&_\[cmdk-item\]_svg\]\:h-5 [cmdk-item] svg { height: 1.25rem; }
.\[\&_\[cmdk-item\]_svg\]\:w-5 [cmdk-item] svg { width: 1.25rem; }
.\[\&_p\]\:leading-relaxed p { line-height: 1.625; }
.\[\&_svg\]\:pointer-events-none svg { pointer-events: none; }
.\[\&_svg\]\:size-4 svg { width: 1rem; height: 1rem; }
.\[\&_svg\]\:shrink-0 svg { flex-shrink: 0; }
.\[\&_tr\:last-child\]\:border-0 tr:last-child { border-width: 0px; }
.\[\&_tr\]\:border-b tr { border-bottom-width: 1px; }
[data-side="left"][data-collapsible="offcanvas"] .\[\[data-side\=left\]\[data-collapsible\=offcanvas\]_\&\]\:-right-2 { right: -0.5rem; }
[data-side="left"][data-state="collapsed"] .\[\[data-side\=left\]\[data-state\=collapsed\]_\&\]\:cursor-e-resize { cursor: e-resize; }
[data-side="left"] .\[\[data-side\=left\]_\&\]\:cursor-w-resize { cursor: w-resize; }
[data-side="right"][data-collapsible="offcanvas"] .\[\[data-side\=right\]\[data-collapsible\=offcanvas\]_\&\]\:-left-2 { left: -0.5rem; }
[data-side="right"][data-state="collapsed"] .\[\[data-side\=right\]\[data-state\=collapsed\]_\&\]\:cursor-w-resize { cursor: w-resize; }
[data-side="right"] .\[\[data-side\=right\]_\&\]\:cursor-e-resize { cursor: e-resize; }

  </style>
  <script>
    
      function formatDate(dateString) {
        const parts = dateString.split('-');
        if (parts.length !== 3) return dateString;
        
        const date = new Date(
          parseInt(parts[0]), 
          parseInt(parts[1]) - 1,
          parseInt(parts[2])
        );
        
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        return months[date.getMonth()] + ' ' + date.getDate() + ', ' + date.getFullYear();
      }
    
  </script>
</head>
<body>
  <div class="max-w-4xl mx-auto p-4 font-sans">
    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
      <!-- Email Header -->
      <div class="bg-gradient-to-r from-blue-50 to-white border-b border-gray-200 p-4 flex justify-end items-center space-x-2">
        <div class="flex items-center text-sm text-gray-600 mr-2 self-end font-medium">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-1 text-blue-500"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
          <span>913-232-2255</span>
        </div>
        <div class="flex items-center text-sm text-gray-600 mr-2 self-end font-medium">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-1 text-blue-500"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
          <span>support@bidsportal.com</span>
        </div>
        <div class="flex items-center ml-4">
          <img 
            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKAAAABUCAYAAAAM5uu/AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAMwSURBVHgB7dzBbdtAEIXhWYILsEtwB1YHZgdWB3YHUQdRB2EHUQdWB1YH7CDswN4Dh4EgBFmtsOQMl/8H8MAlJXLJpxnt7o4mAAAAAAAAAAAAAAC4p7fE5+fn1+12+zGGP9HlRhm9Mdfr9efb29uv1JdMCRgJ9x5D9NPXEcn4Z5qmn6kvKQkYifc1hh+uvQYunT+xBPxIyEN0CbM1NuCU+MNsyzGWRwLCkYBwJCAcCQhHAsKRgHAkIBwJCEcCwpGAcCQgHAkIRwLCkYBwJCAcCQiXOZCd77cw5yPg3ebV5tXnXf9Fv+Qj2Z9jeIy597f27mKM/MJ28JZ4Z2yLMK9/9iJJUzPRxLk2dkl9Yb6wnbQmYJ41OA9O5XWZZw1CXZYurLdNQmXtnSQ2Ss3Wtk6S0Fd2CeXK32ZuKLVbi9LxUEsZiucV+5gqHcssuQ80NWvb5OwD0mN2HJPkE/1nydvkPAI6/y5tM5RtnTwCNl7a2iRvk7ENqHnFPibJJ/rP0rfJ1gZ0Xe8Zbaw39zXJ2Qkp2gGJrXhkOtu55U1jLDgNZdnJLflhTr7HiHMvwuxZj4yTeNrI+jHrXmTHe4y41ZuR9qmZe+rnLIGsM9HxHiUu0b0TYzlVz0mC2NccNnuMuFUeJ2T/H1lHx/HuHcK2yDrP1nE+Yi95Py+22Y5EcNb3ggHrLHmbrFuxnm24veTnq+o0lGsnRnLdA81ck7ZN9pGwWo+A9ZZ8JiHsULTnvWC+pBzVdC2xST8VK+s7IfpoRFn28zLbY4ezPeaFNXZXMt4JMn8v2PvesPzUTEzMnc31GrKDJa1nnZvqOeLTQNZ3Qkzft0LF52bGRCndKxOPtHd/L/geeZvmC9vB0sLUKSF7T0JAQwLCkYBwJCAcCQhHAsKRgHAkIBwJCEcCwpGAcCQgHAkIRwLCkYBwJCAcM1GMy/V6TTbXbY+Aj/H+Pft8+D2xvWmapn+pL8kJGLOtyvjH6Kcp0XfVSHtvsdQrX/OVb5HE64a+AQAAAAAAAAAAAAAA3NYf+rSjOdJPpKMAAAAASUVORK5CYII="
            alt="BidsPortal Logo" 
            class="h-10 w-auto" 
          />
        </div>
      </div>

      <!-- Alert Header -->
      <div class="flex justify-between items-center p-4 border-b border-gray-200 bg-blue-50">
        <div class="flex items-center">
          <div class="bg-blue-500 p-2 rounded-full mr-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-white"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path><path d="M4 2C2.8 3.7 2 5.7 2 8"></path><path d="M22 8c0-2.3-.8-4.3-2-6"></path></svg>
          </div>
          <div>
            <h1 class="font-medium text-lg text-gray-800">Daily Alert for "Users Alert Name Here"</h1>
            <div class="flex items-center space-x-3">
              <p class="text-sm text-gray-500">Your personalized bid notifications</p>
              <div class="h-4 bg-gray-300 w-px"></div>
              <span class="text-xs text-gray-600 italic flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1 text-yellow-500"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                Please contact the buyer for the latest addenda to any solicitation.
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Bids List -->
      <div class="p-6 bg-gray-50">
        <div class="flex justify-between items-center mb-4">
          <p class="text-sm text-gray-600 font-medium flex items-center">
            Showing 15 out of 30 matching bids for your search - to explore the full list, click here
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 ml-1 text-blue-500"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
          </p>
          <button 
            class="text-blue-600 border-blue-200 hover:bg-blue-50 text-xs py-1 px-3 h-auto border rounded-md"
          >
            View All Opportunities
          </button>
        </div>
        
        <div class="space-y-3">
          
        <div class="overflow-hidden hover:shadow-md transition-shadow duration-300 border-gray-200 hover:border-blue-200 bg-white rounded-lg shadow-md mb-3 border">
          <div class="border-b border-gray-100 bg-blue-50/50 p-3 flex justify-between items-center">
            <div>
              <h3 class="text-md font-semibold text-gray-800">
                City Infrastructure Development Project
              </h3>
              <div class="flex flex-wrap gap-x-4 gap-y-1 text-sm mt-1">
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" x2="8" y1="13" y2="13"></line><line x1="16" x2="8" y1="17" y2="17"></line><line x1="10" x2="8" y1="9" y2="9"></line></svg>
                  <span class="font-medium mr-1">ID:</span> BID-2023-0001
                </span>
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                  <span class="font-medium mr-1">Type:</span> Request for Proposal
                </span>
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect><path d="M9 22v-4h6v4"></path><path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path><path d="M12 10h.01"></path><path d="M12 14h.01"></path><path d="M16 10h.01"></path><path d="M16 14h.01"></path><path d="M8 10h.01"></path><path d="M8 14h.01"></path></svg>
                  <span class="font-medium mr-1">Agency:</span> Department of Public Works
                </span>
              </div>
            </div>
            <button class="text-blue-500 border-gray-300 hover:bg-gray-50 text-xs py-1 px-1 h-auto flex items-center border rounded-md">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" x2="21" y1="14" y2="3"></line></svg>
              View Details
            </button>
          </div>
          
          <div class="p-3">
            <div class="text-sm text-gray-600 border-b border-gray-100 pb-2 mb-2 max-w-2xl">
              <p class="line-clamp-2">Seeking proposals for the renovation and upgrade of public infrastructure including roads, bridges, and utility systems in the downtown area.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                <div>
                  <p class="text-gray-500">Posted:</p>
                  <p class="font-medium"><script>document.write(formatDate("2023-11-20"))</script></p>
                </div>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <div>
                  <p class="text-gray-500">Due Date:</p>
                  <p class="font-medium"><script>document.write(formatDate("2023-12-15"))</script></p>
                </div>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <div>
                  <p class="text-gray-500">Location:</p>
                  <p class="font-medium">San Francisco, CA</p>
                </div>
              </div>
              <div class="flex items-center text-xs">
                <div class="px-2 py-1 rounded-full flex items-center bg-green-50">
                  <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1 text-green-500">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                  </svg>
                  <span class="font-medium text-green-600">
                    8 days left
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      
        <div class="overflow-hidden hover:shadow-md transition-shadow duration-300 border-gray-200 hover:border-blue-200 bg-white rounded-lg shadow-md mb-3 border">
          <div class="border-b border-gray-100 bg-blue-50/50 p-3 flex justify-between items-center">
            <div>
              <h3 class="text-md font-semibold text-gray-800">
                Healthcare IT Systems Modernization
              </h3>
              <div class="flex flex-wrap gap-x-4 gap-y-1 text-sm mt-1">
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" x2="8" y1="13" y2="13"></line><line x1="16" x2="8" y1="17" y2="17"></line><line x1="10" x2="8" y1="9" y2="9"></line></svg>
                  <span class="font-medium mr-1">ID:</span> BID-2023-0002
                </span>
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                  <span class="font-medium mr-1">Type:</span> Request for Information
                </span>
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect><path d="M9 22v-4h6v4"></path><path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path><path d="M12 10h.01"></path><path d="M12 14h.01"></path><path d="M16 10h.01"></path><path d="M16 14h.01"></path><path d="M8 10h.01"></path><path d="M8 14h.01"></path></svg>
                  <span class="font-medium mr-1">Agency:</span> Department of Health
                </span>
              </div>
            </div>
            <button class="text-blue-500 border-gray-300 hover:bg-gray-50 text-xs py-1 px-1 h-auto flex items-center border rounded-md">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" x2="21" y1="14" y2="3"></line></svg>
              View Details
            </button>
          </div>
          
          <div class="p-3">
            <div class="text-sm text-gray-600 border-b border-gray-100 pb-2 mb-2 max-w-2xl">
              <p class="line-clamp-2">Looking for information on modern healthcare management systems with focus on patient data security and interoperability.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                <div>
                  <p class="text-gray-500">Posted:</p>
                  <p class="font-medium"><script>document.write(formatDate("2023-11-19"))</script></p>
                </div>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <div>
                  <p class="text-gray-500">Due Date:</p>
                  <p class="font-medium"><script>document.write(formatDate("2023-12-10"))</script></p>
                </div>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <div>
                  <p class="text-gray-500">Location:</p>
                  <p class="font-medium">Boston, MA</p>
                </div>
              </div>
              <div class="flex items-center text-xs">
                <div class="px-2 py-1 rounded-full flex items-center bg-orange-100">
                  <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1 text-orange-500">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                  </svg>
                  <span class="font-medium text-orange-700">
                    3 days left
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      
        <div class="overflow-hidden hover:shadow-md transition-shadow duration-300 border-gray-200 hover:border-blue-200 bg-white rounded-lg shadow-md mb-3 border">
          <div class="border-b border-gray-100 bg-blue-50/50 p-3 flex justify-between items-center">
            <div>
              <h3 class="text-md font-semibold text-gray-800">
                School District Transportation Services
              </h3>
              <div class="flex flex-wrap gap-x-4 gap-y-1 text-sm mt-1">
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" x2="8" y1="13" y2="13"></line><line x1="16" x2="8" y1="17" y2="17"></line><line x1="10" x2="8" y1="9" y2="9"></line></svg>
                  <span class="font-medium mr-1">ID:</span> BID-2023-0003
                </span>
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                  <span class="font-medium mr-1">Type:</span> Invitation for Bid
                </span>
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect><path d="M9 22v-4h6v4"></path><path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path><path d="M12 10h.01"></path><path d="M12 14h.01"></path><path d="M16 10h.01"></path><path d="M16 14h.01"></path><path d="M8 10h.01"></path><path d="M8 14h.01"></path></svg>
                  <span class="font-medium mr-1">Agency:</span> Board of Education
                </span>
              </div>
            </div>
            <button class="text-blue-500 border-gray-300 hover:bg-gray-50 text-xs py-1 px-1 h-auto flex items-center border rounded-md">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" x2="21" y1="14" y2="3"></line></svg>
              View Details
            </button>
          </div>
          
          <div class="p-3">
            <div class="text-sm text-gray-600 border-b border-gray-100 pb-2 mb-2 max-w-2xl">
              <p class="line-clamp-2">Seeking bids for providing transportation services for students within the school district, including special needs transportation.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                <div>
                  <p class="text-gray-500">Posted:</p>
                  <p class="font-medium"><script>document.write(formatDate("2023-11-18"))</script></p>
                </div>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <div>
                  <p class="text-gray-500">Due Date:</p>
                  <p class="font-medium"><script>document.write(formatDate("2023-12-08"))</script></p>
                </div>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <div>
                  <p class="text-gray-500">Location:</p>
                  <p class="font-medium">Chicago, IL</p>
                </div>
              </div>
              <div class="flex items-center text-xs">
                <div class="px-2 py-1 rounded-full flex items-center bg-red-100">
                  <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1 text-red-600">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                  </svg>
                  <span class="font-medium text-red-700">
                    1 days left
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      
        <div class="overflow-hidden hover:shadow-md transition-shadow duration-300 border-gray-200 hover:border-blue-200 bg-white rounded-lg shadow-md mb-3 border">
          <div class="border-b border-gray-100 bg-blue-50/50 p-3 flex justify-between items-center">
            <div>
              <h3 class="text-md font-semibold text-gray-800">
                Municipal Waste Management System
              </h3>
              <div class="flex flex-wrap gap-x-4 gap-y-1 text-sm mt-1">
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" x2="8" y1="13" y2="13"></line><line x1="16" x2="8" y1="17" y2="17"></line><line x1="10" x2="8" y1="9" y2="9"></line></svg>
                  <span class="font-medium mr-1">ID:</span> BID-2023-0004
                </span>
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                  <span class="font-medium mr-1">Type:</span> Request for Proposal
                </span>
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect><path d="M9 22v-4h6v4"></path><path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path><path d="M12 10h.01"></path><path d="M12 14h.01"></path><path d="M16 10h.01"></path><path d="M16 14h.01"></path><path d="M8 10h.01"></path><path d="M8 14h.01"></path></svg>
                  <span class="font-medium mr-1">Agency:</span> Environmental Protection Department
                </span>
              </div>
            </div>
            <button class="text-blue-500 border-gray-300 hover:bg-gray-50 text-xs py-1 px-1 h-auto flex items-center border rounded-md">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" x2="21" y1="14" y2="3"></line></svg>
              View Details
            </button>
          </div>
          
          <div class="p-3">
            <div class="text-sm text-gray-600 border-b border-gray-100 pb-2 mb-2 max-w-2xl">
              <p class="line-clamp-2">Proposals for implementing a comprehensive waste management system with focus on recycling and sustainability practices.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                <div>
                  <p class="text-gray-500">Posted:</p>
                  <p class="font-medium"><script>document.write(formatDate("2023-11-21"))</script></p>
                </div>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <div>
                  <p class="text-gray-500">Due Date:</p>
                  <p class="font-medium"><script>document.write(formatDate("2023-12-20"))</script></p>
                </div>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <div>
                  <p class="text-gray-500">Location:</p>
                  <p class="font-medium">Seattle, WA</p>
                </div>
              </div>
              <div class="flex items-center text-xs">
                <div class="px-2 py-1 rounded-full flex items-center bg-green-50">
                  <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1 text-green-500">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                  </svg>
                  <span class="font-medium text-green-600">
                    13 days left
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      
        <div class="overflow-hidden hover:shadow-md transition-shadow duration-300 border-gray-200 hover:border-blue-200 bg-white rounded-lg shadow-md mb-3 border">
          <div class="border-b border-gray-100 bg-blue-50/50 p-3 flex justify-between items-center">
            <div>
              <h3 class="text-md font-semibold text-gray-800">
                Public Library Technology Upgrade
              </h3>
              <div class="flex flex-wrap gap-x-4 gap-y-1 text-sm mt-1">
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" x2="8" y1="13" y2="13"></line><line x1="16" x2="8" y1="17" y2="17"></line><line x1="10" x2="8" y1="9" y2="9"></line></svg>
                  <span class="font-medium mr-1">ID:</span> BID-2023-0005
                </span>
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                  <span class="font-medium mr-1">Type:</span> Request for Quotation
                </span>
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect><path d="M9 22v-4h6v4"></path><path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path><path d="M12 10h.01"></path><path d="M12 14h.01"></path><path d="M16 10h.01"></path><path d="M16 14h.01"></path><path d="M8 10h.01"></path><path d="M8 14h.01"></path></svg>
                  <span class="font-medium mr-1">Agency:</span> Public Library Board
                </span>
              </div>
            </div>
            <button class="text-blue-500 border-gray-300 hover:bg-gray-50 text-xs py-1 px-1 h-auto flex items-center border rounded-md">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" x2="21" y1="14" y2="3"></line></svg>
              View Details
            </button>
          </div>
          
          <div class="p-3">
            <div class="text-sm text-gray-600 border-b border-gray-100 pb-2 mb-2 max-w-2xl">
              <p class="line-clamp-2">Seeking quotations for upgrading computer systems, network infrastructure, and digital resources across all branches of the public library.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                <div>
                  <p class="text-gray-500">Posted:</p>
                  <p class="font-medium"><script>document.write(formatDate("2023-11-17"))</script></p>
                </div>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <div>
                  <p class="text-gray-500">Due Date:</p>
                  <p class="font-medium"><script>document.write(formatDate("2023-12-05"))</script></p>
                </div>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <div>
                  <p class="text-gray-500">Location:</p>
                  <p class="font-medium">Austin, TX</p>
                </div>
              </div>
              <div class="flex items-center text-xs">
                <div class="px-2 py-1 rounded-full flex items-center bg-red-100">
                  <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1 text-red-600">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                  </svg>
                  <span class="font-medium text-red-700">
                    Closing Today
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      
        <div class="overflow-hidden hover:shadow-md transition-shadow duration-300 border-gray-200 hover:border-blue-200 bg-white rounded-lg shadow-md mb-3 border">
          <div class="border-b border-gray-100 bg-blue-50/50 p-3 flex justify-between items-center">
            <div>
              <h3 class="text-md font-semibold text-gray-800">
                Emergency Response Equipment
              </h3>
              <div class="flex flex-wrap gap-x-4 gap-y-1 text-sm mt-1">
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" x2="8" y1="13" y2="13"></line><line x1="16" x2="8" y1="17" y2="17"></line><line x1="10" x2="8" y1="9" y2="9"></line></svg>
                  <span class="font-medium mr-1">ID:</span> BID-2023-0006
                </span>
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                  <span class="font-medium mr-1">Type:</span> Request for Proposal
                </span>
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect><path d="M9 22v-4h6v4"></path><path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path><path d="M12 10h.01"></path><path d="M12 14h.01"></path><path d="M16 10h.01"></path><path d="M16 14h.01"></path><path d="M8 10h.01"></path><path d="M8 14h.01"></path></svg>
                  <span class="font-medium mr-1">Agency:</span> Emergency Management Office
                </span>
              </div>
            </div>
            <button class="text-blue-500 border-gray-300 hover:bg-gray-50 text-xs py-1 px-1 h-auto flex items-center border rounded-md">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" x2="21" y1="14" y2="3"></line></svg>
              View Details
            </button>
          </div>
          
          <div class="p-3">
            <div class="text-sm text-gray-600 border-b border-gray-100 pb-2 mb-2 max-w-2xl">
              <p class="line-clamp-2">Proposals for supplying emergency response equipment including communication devices, medical supplies, and safety gear for first responders.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                <div>
                  <p class="text-gray-500">Posted:</p>
                  <p class="font-medium"><script>document.write(formatDate("2023-11-22"))</script></p>
                </div>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <div>
                  <p class="text-gray-500">Due Date:</p>
                  <p class="font-medium"><script>document.write(formatDate("2023-12-22"))</script></p>
                </div>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <div>
                  <p class="text-gray-500">Location:</p>
                  <p class="font-medium">Denver, CO</p>
                </div>
              </div>
              <div class="flex items-center text-xs">
                <div class="px-2 py-1 rounded-full flex items-center bg-green-50">
                  <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1 text-green-500">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                  </svg>
                  <span class="font-medium text-green-600">
                    15 days left
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      
        <div class="overflow-hidden hover:shadow-md transition-shadow duration-300 border-gray-200 hover:border-blue-200 bg-white rounded-lg shadow-md mb-3 border">
          <div class="border-b border-gray-100 bg-blue-50/50 p-3 flex justify-between items-center">
            <div>
              <h3 class="text-md font-semibold text-gray-800">
                Community Center Renovation
              </h3>
              <div class="flex flex-wrap gap-x-4 gap-y-1 text-sm mt-1">
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" x2="8" y1="13" y2="13"></line><line x1="16" x2="8" y1="17" y2="17"></line><line x1="10" x2="8" y1="9" y2="9"></line></svg>
                  <span class="font-medium mr-1">ID:</span> BID-2023-0007
                </span>
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                  <span class="font-medium mr-1">Type:</span> Request for Proposal
                </span>
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect><path d="M9 22v-4h6v4"></path><path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path><path d="M12 10h.01"></path><path d="M12 14h.01"></path><path d="M16 10h.01"></path><path d="M16 14h.01"></path><path d="M8 10h.01"></path><path d="M8 14h.01"></path></svg>
                  <span class="font-medium mr-1">Agency:</span> Parks & Recreation Department
                </span>
              </div>
            </div>
            <button class="text-blue-500 border-gray-300 hover:bg-gray-50 text-xs py-1 px-1 h-auto flex items-center border rounded-md">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" x2="21" y1="14" y2="3"></line></svg>
              View Details
            </button>
          </div>
          
          <div class="p-3">
            <div class="text-sm text-gray-600 border-b border-gray-100 pb-2 mb-2 max-w-2xl">
              <p class="line-clamp-2">Proposals for renovation of community center including accessibility upgrades, energy-efficient systems, and modern facilities.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                <div>
                  <p class="text-gray-500">Posted:</p>
                  <p class="font-medium"><script>document.write(formatDate("2023-11-25"))</script></p>
                </div>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <div>
                  <p class="text-gray-500">Due Date:</p>
                  <p class="font-medium"><script>document.write(formatDate("2023-12-25"))</script></p>
                </div>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <div>
                  <p class="text-gray-500">Location:</p>
                  <p class="font-medium">Portland, OR</p>
                </div>
              </div>
              <div class="flex items-center text-xs">
                <div class="px-2 py-1 rounded-full flex items-center bg-green-50">
                  <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1 text-green-500">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                  </svg>
                  <span class="font-medium text-green-600">
                    18 days left
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      
        <div class="overflow-hidden hover:shadow-md transition-shadow duration-300 border-gray-200 hover:border-blue-200 bg-white rounded-lg shadow-md mb-3 border">
          <div class="border-b border-gray-100 bg-blue-50/50 p-3 flex justify-between items-center">
            <div>
              <h3 class="text-md font-semibold text-gray-800">
                Smart Traffic Management Solutions
              </h3>
              <div class="flex flex-wrap gap-x-4 gap-y-1 text-sm mt-1">
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" x2="8" y1="13" y2="13"></line><line x1="16" x2="8" y1="17" y2="17"></line><line x1="10" x2="8" y1="9" y2="9"></line></svg>
                  <span class="font-medium mr-1">ID:</span> BID-2023-0008
                </span>
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                  <span class="font-medium mr-1">Type:</span> Request for Information
                </span>
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect><path d="M9 22v-4h6v4"></path><path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path><path d="M12 10h.01"></path><path d="M12 14h.01"></path><path d="M16 10h.01"></path><path d="M16 14h.01"></path><path d="M8 10h.01"></path><path d="M8 14h.01"></path></svg>
                  <span class="font-medium mr-1">Agency:</span> Department of Transportation
                </span>
              </div>
            </div>
            <button class="text-blue-500 border-gray-300 hover:bg-gray-50 text-xs py-1 px-1 h-auto flex items-center border rounded-md">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" x2="21" y1="14" y2="3"></line></svg>
              View Details
            </button>
          </div>
          
          <div class="p-3">
            <div class="text-sm text-gray-600 border-b border-gray-100 pb-2 mb-2 max-w-2xl">
              <p class="line-clamp-2">Seeking information on smart traffic management solutions to reduce congestion and improve traffic flow in metropolitan areas.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                <div>
                  <p class="text-gray-500">Posted:</p>
                  <p class="font-medium"><script>document.write(formatDate("2023-11-26"))</script></p>
                </div>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <div>
                  <p class="text-gray-500">Due Date:</p>
                  <p class="font-medium"><script>document.write(formatDate("2023-12-18"))</script></p>
                </div>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <div>
                  <p class="text-gray-500">Location:</p>
                  <p class="font-medium">Atlanta, GA</p>
                </div>
              </div>
              <div class="flex items-center text-xs">
                <div class="px-2 py-1 rounded-full flex items-center bg-green-50">
                  <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1 text-green-500">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                  </svg>
                  <span class="font-medium text-green-600">
                    11 days left
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      
        <div class="overflow-hidden hover:shadow-md transition-shadow duration-300 border-gray-200 hover:border-blue-200 bg-white rounded-lg shadow-md mb-3 border">
          <div class="border-b border-gray-100 bg-blue-50/50 p-3 flex justify-between items-center">
            <div>
              <h3 class="text-md font-semibold text-gray-800">
                Public School Security Systems
              </h3>
              <div class="flex flex-wrap gap-x-4 gap-y-1 text-sm mt-1">
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" x2="8" y1="13" y2="13"></line><line x1="16" x2="8" y1="17" y2="17"></line><line x1="10" x2="8" y1="9" y2="9"></line></svg>
                  <span class="font-medium mr-1">ID:</span> BID-2023-0009
                </span>
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                  <span class="font-medium mr-1">Type:</span> Invitation for Bid
                </span>
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect><path d="M9 22v-4h6v4"></path><path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path><path d="M12 10h.01"></path><path d="M12 14h.01"></path><path d="M16 10h.01"></path><path d="M16 14h.01"></path><path d="M8 10h.01"></path><path d="M8 14h.01"></path></svg>
                  <span class="font-medium mr-1">Agency:</span> School District
                </span>
              </div>
            </div>
            <button class="text-blue-500 border-gray-300 hover:bg-gray-50 text-xs py-1 px-1 h-auto flex items-center border rounded-md">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" x2="21" y1="14" y2="3"></line></svg>
              View Details
            </button>
          </div>
          
          <div class="p-3">
            <div class="text-sm text-gray-600 border-b border-gray-100 pb-2 mb-2 max-w-2xl">
              <p class="line-clamp-2">Bids for installation of comprehensive security systems including cameras, access control, and emergency alert systems across all district schools.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                <div>
                  <p class="text-gray-500">Posted:</p>
                  <p class="font-medium"><script>document.write(formatDate("2023-11-27"))</script></p>
                </div>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <div>
                  <p class="text-gray-500">Due Date:</p>
                  <p class="font-medium"><script>document.write(formatDate("2023-12-16"))</script></p>
                </div>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <div>
                  <p class="text-gray-500">Location:</p>
                  <p class="font-medium">Miami, FL</p>
                </div>
              </div>
              <div class="flex items-center text-xs">
                <div class="px-2 py-1 rounded-full flex items-center bg-green-50">
                  <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1 text-green-500">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                  </svg>
                  <span class="font-medium text-green-600">
                    9 days left
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      
        <div class="overflow-hidden hover:shadow-md transition-shadow duration-300 border-gray-200 hover:border-blue-200 bg-white rounded-lg shadow-md mb-3 border">
          <div class="border-b border-gray-100 bg-blue-50/50 p-3 flex justify-between items-center">
            <div>
              <h3 class="text-md font-semibold text-gray-800">
                Water Treatment Plant Upgrade
              </h3>
              <div class="flex flex-wrap gap-x-4 gap-y-1 text-sm mt-1">
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" x2="8" y1="13" y2="13"></line><line x1="16" x2="8" y1="17" y2="17"></line><line x1="10" x2="8" y1="9" y2="9"></line></svg>
                  <span class="font-medium mr-1">ID:</span> BID-2023-0010
                </span>
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                  <span class="font-medium mr-1">Type:</span> Request for Proposal
                </span>
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect><path d="M9 22v-4h6v4"></path><path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path><path d="M12 10h.01"></path><path d="M12 14h.01"></path><path d="M16 10h.01"></path><path d="M16 14h.01"></path><path d="M8 10h.01"></path><path d="M8 14h.01"></path></svg>
                  <span class="font-medium mr-1">Agency:</span> Water Resources Department
                </span>
              </div>
            </div>
            <button class="text-blue-500 border-gray-300 hover:bg-gray-50 text-xs py-1 px-1 h-auto flex items-center border rounded-md">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" x2="21" y1="14" y2="3"></line></svg>
              View Details
            </button>
          </div>
          
          <div class="p-3">
            <div class="text-sm text-gray-600 border-b border-gray-100 pb-2 mb-2 max-w-2xl">
              <p class="line-clamp-2">Proposals for upgrading municipal water treatment facilities to improve water quality and increase processing capacity.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                <div>
                  <p class="text-gray-500">Posted:</p>
                  <p class="font-medium"><script>document.write(formatDate("2023-11-28"))</script></p>
                </div>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <div>
                  <p class="text-gray-500">Due Date:</p>
                  <p class="font-medium"><script>document.write(formatDate("2023-12-28"))</script></p>
                </div>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <div>
                  <p class="text-gray-500">Location:</p>
                  <p class="font-medium">Phoenix, AZ</p>
                </div>
              </div>
              <div class="flex items-center text-xs">
                <div class="px-2 py-1 rounded-full flex items-center bg-green-50">
                  <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1 text-green-500">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                  </svg>
                  <span class="font-medium text-green-600">
                    21 days left
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      
        <div class="overflow-hidden hover:shadow-md transition-shadow duration-300 border-gray-200 hover:border-blue-200 bg-white rounded-lg shadow-md mb-3 border">
          <div class="border-b border-gray-100 bg-blue-50/50 p-3 flex justify-between items-center">
            <div>
              <h3 class="text-md font-semibold text-gray-800">
                City Park Landscaping Services
              </h3>
              <div class="flex flex-wrap gap-x-4 gap-y-1 text-sm mt-1">
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" x2="8" y1="13" y2="13"></line><line x1="16" x2="8" y1="17" y2="17"></line><line x1="10" x2="8" y1="9" y2="9"></line></svg>
                  <span class="font-medium mr-1">ID:</span> BID-2023-0011
                </span>
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                  <span class="font-medium mr-1">Type:</span> Request for Quotation
                </span>
                <span class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1 text-blue-500"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect><path d="M9 22v-4h6v4"></path><path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path><path d="M12 10h.01"></path><path d="M12 14h.01"></path><path d="M16 10h.01"></path><path d="M16 14h.01"></path><path d="M8 10h.01"></path><path d="M8 14h.01"></path></svg>
                  <span class="font-medium mr-1">Agency:</span> Parks Department
                </span>
              </div>
            </div>
            <button class="text-blue-500 border-gray-300 hover:bg-gray-50 text-xs py-1 px-1 h-auto flex items-center border rounded-md">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" x2="21" y1="14" y2="3"></line></svg>
              View Details
            </button>
          </div>
          
          <div class="p-3">
            <div class="text-sm text-gray-600 border-b border-gray-100 pb-2 mb-2 max-w-2xl">
              <p class="line-clamp-2">Quotations for ongoing landscaping and maintenance services for city parks and recreational areas.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                <div>
                  <p class="text-gray-500">Posted:</p>
                  <p class="font-medium"><script>document.write(formatDate("2023-11-29"))</script></p>
                </div>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <div>
                  <p class="text-gray-500">Due Date:</p>
                  <p class="font-medium"><script>document.write(formatDate("2023-12-12"))</script></p>
                </div>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 mr-1.5 text-blue-500"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <div>
                  <p class="text-gray-500">Location:</p>
                  <p class="font-medium">San Diego, CA</p>
                </div>
              </div>
              <div class="flex items-center text-xs">
                <div class="px-2 py-1 rounded-full flex items-center bg-green-50">
                  <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1 text-green-500">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                  </svg>
                  <span class="font-medium text-green-600">
                    5 days left
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      
        </div>
      </div>

      <!-- Footer -->
      <div class="bg-gradient-to-r from-blue-50 to-gray-50 p-4 border-t border-gray-200 text-xs text-gray-600">
        <p class="text-center mb-2">This is a system generated email - Please do not reply to it. If you have any queries, please email <a href="mailto:support@bidsportal.com" class="text-blue-600 hover:underline">support@bidsportal.com</a> or call 913-232-2255.</p>
        
        <p class="text-center mt-4 font-medium">© 2018-2025 | All rights reserved - BidsPortal</p>
      </div>
    </div>
  </div>
</body>
</html>
    