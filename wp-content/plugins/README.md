# WordPress Custom Plugins - Implementation Guide

This document explains how to set up and use two custom WordPress plugins for WooCommerce and Gutenberg blocks.

---

## Task 1: Custom Size-Based Product Variations with Dynamic Pricing

### What This Plugin Does
This plugin allows you to sell products with custom dimensions (like posters, frames, or glass panels). Customers can enter their desired height and width, and the price automatically calculates based on the size ranges you define.

### Installation Steps

1. **Activate the Plugin**
   - Go to your WordPress admin dashboard
   - Navigate to **Plugins** in the left sidebar
   - Find **"Custom Size Pricing"** in the list
   - Click the **Activate** button

2. **Set Up a Product**
   - Go to **Products** → **Add New** (or edit an existing product)
   - Fill in the basic product details (name, description, etc.)
   - You can set the regular price to $0 since custom pricing will override it

3. **Add Size Ranges**
   - Scroll down on the product edit page
   - Find the **"Custom Size Pricing"** box
   - Click the **"Add Size Range"** button
   - Fill in the fields for your first size range:
     - **Height Min**: The minimum height (e.g., 0)
     - **Height Max**: The maximum height (e.g., 10)
     - **Width Min**: The minimum width (e.g., 0)
     - **Width Max**: The maximum width (e.g., 20)
     - **Price**: The price for this size range (e.g., 15)
   - Click **"Add Size Range"** again to add more ranges
   - Example setup:
     ```
     Small: Height 0-10, Width 0-20, Price $15
     Medium: Height 10-20, Width 20-40, Price $30
     Large: Height 20-30, Width 40-60, Price $50
     ```

4. **Save the Product**
   - Click **Publish** (for new products) or **Update** (for existing products)

### How Customers Use It

1. Customer visits your product page
2. They see two input fields: **Height** and **Width**
3. As they type in dimensions, the price automatically calculates
4. If dimensions match a range you defined, the price displays
5. If dimensions don't match any range, an error message appears
6. Customer clicks **Add to Cart**
7. In the cart and checkout, they see:
   - The custom height they entered
   - The custom width they entered
   - The calculated price

### Important Tips

- **No Gaps**: Make sure your size ranges don't have gaps. If one range ends at 10, the next should start at 10.01
- **No Overlaps**: Don't let ranges overlap, or customers might get unexpected prices
- **Be Consistent**: Use the same units (inches, cm, etc.) for all ranges
- **Test It**: After setup, test by entering different dimensions to make sure pricing works correctly

---

## Task 2: News Grid Gutenberg Block

### What This Plugin Does
This plugin creates a custom "News" post type and a Gutenberg block that displays news posts in a beautiful 3-column grid. You can filter by category and choose how many posts to show.

### Installation Steps

1. **Activate the Plugin**
   - Go to your WordPress admin dashboard
   - Navigate to **Plugins** in the left sidebar
   - Find **"News Grid Block"** in the list
   - Click the **Activate** button

2. **Refresh Permalinks** (Important!)
   - Go to **Settings** → **Permalinks**
   - Don't change anything, just click **Save Changes**
   - This registers the new "News" post type properly

3. **Create News Categories** (Optional but Recommended)
   - Look for **News** in the left sidebar
   - Click **News Categories**
   - Add categories like "Technology", "Sports", "Business", etc.
   - Click **Add New News Category** for each one

4. **Add News Posts**
   - Click **News** → **Add New** in the left sidebar
   - Fill in the details:
     - **Title**: Your news headline (e.g., "New Product Launch")
     - **Content**: Write your news article
     - **Featured Image**: Click "Set featured image" on the right → Upload an image → Click "Set featured image"
     - **Category**: Select a category from the right sidebar
   - Click **Publish**
   - Repeat to create at least 3-6 news posts

### How to Use the Block

1. **Add Block to a Page**
   - Go to **Pages** → **Add New** (or edit an existing page)
   - Click the **+** button to add a new block
   - Search for **"News Grid"**
   - Click on it to insert the block

2. **Configure the Block**
   - After inserting the block, look at the **right sidebar**
   - You'll see two dropdown menus:
     - **Category**: Choose a specific category or leave as "All Categories"
     - **Posts to Show**: Select 3, 6, 9, or 12 posts
   - The block will automatically update based on your selections

3. **Publish the Page**
   - Click **Publish** or **Update**
   - Click **View Page** to see your news grid

### What Visitors See

- A beautiful 3-column grid of news posts
- Each post shows:
  - A thumbnail image at the top
  - The post title below the image
- Both the image and title are clickable
- Clicking takes them to the full news article
- On tablets, it shows 2 columns
- On phones, it shows 1 column (responsive design)

### Tips for Best Results

- **Always Add Featured Images**: Posts without featured images won't look good in the grid
- **Use Good Quality Images**: Images should be at least 600x400 pixels
- **Keep Titles Short**: Long titles might wrap awkwardly in the grid
- **Test Different Layouts**: Try different post counts (3, 6, 9, 12) to see what looks best on your page

---

## Troubleshooting

### Task 1 Issues

**Problem**: Meta box doesn't appear on product page
- **Solution**: Make sure the plugin is activated and you're editing a WooCommerce product (not a regular post)

**Problem**: Price doesn't calculate
- **Solution**: Check browser console (F12) for errors. Make sure you've added at least one size range to the product

**Problem**: Can't add to cart
- **Solution**: The button is disabled until valid dimensions are entered. Make sure your dimensions match one of your defined ranges

### Task 2 Issues

**Problem**: "News" menu doesn't appear
- **Solution**: Deactivate and reactivate the plugin, then go to Settings → Permalinks → Save Changes

**Problem**: Block doesn't show posts
- **Solution**: Make sure you've created and published news posts with featured images

**Problem**: Grid layout is broken
- **Solution**: Your theme might have conflicting CSS. Try clearing your browser cache (Ctrl+F5)

---

## File Locations

**Task 1 Plugin Files:**
```
/wp-content/plugins/custom-size-pricing/
├── custom-size-pricing.php
├── admin/
│   └── product-meta-box.php
├── public/
│   ├── product-page.php
│   └── cart-checkout.php
└── assets/
    ├── admin.js
    ├── admin.css
    ├── frontend.js
    └── frontend.css
```

**Task 2 Plugin Files:**
```
/wp-content/plugins/news-grid-block/
├── news-grid-block.php
├── block.js
└── style.css
```

---

## Support

If you encounter any issues:
1. Check that both plugins are activated
2. Clear your browser cache
3. Check for JavaScript errors in browser console (F12)
4. Make sure you're using a compatible WordPress version (5.0+)
5. Ensure WooCommerce is installed and activated (for Task 1)

---

**Created**: February 2026  
**WordPress Version**: 5.0+  
**WooCommerce Version**: 3.0+ (for Task 1)  
**PHP Version**: 7.0+
