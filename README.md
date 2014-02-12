#Novius Blocks
---
Create and manage your blocks, include them in your content, link them with others applications of your website.

---
##How does it work ? (webmaster oriented)
---
###The appdesk

A simple appdesk where you can find two main panels :
- The **Columns** inspector and management
- The **Blocks** management

From here, you can create, edit or delete your columns and blocks.

###The columns ?
They allow you to create groups of blocks to insert in your pages or applications but it is possible that you don't use them.
You can either affect a block to a column in the edit form of a column itself (add several blocks to a particular column) or in the edit form of a block (affect a particular block in one or many columns).

###Create your blocks
- Chose the type of your block
- Fill in the fields of your block
- Save it !

>####Special fields
>Beseide the title, image and description, you can use more specific fields :

>>####- Link
>>Add a link on your block with a custom URL & title.
>>####- Columns
>>Affect a block to one or many columns
>>####- Link with a model
>>If you want to link your block with an other application of your website (a page or an other specific application), use this panel to link your block to this element. Chose the type of the element to match and find it with the autocompletion. Then you can retrieve some fields like the title, the description, the image or the URL of the element if it's available.
>>####- Configuration
>>For now you can only add css class to your blocks.

###Display your blocks on your website
Wherever there is a Wysiwyg available, (like in the content of the pages for example), you might insert them via the "application" button. You have 2 ways to display blocks :
>- **By choosing a column** : all the Blocks of the column will be displayed in the defined order.
>- **By choosing the blocks** directly; the will appear in the order defined as well.

Boom ! Blocks on your website !

---

##How can you configure it (developper oriented)

---

###Configuration of the templates
<br>
####Default configuration

The config file of the templates is config/templates_default.config.php :

```php
return array(
    'title'             => '',
    'css'               => 'static/apps/novius_blocks/css/front/{name}.css',
    'view'              => 'novius_blocks::templates/{name}',
    'fields'            => array(
        'description',
        'link',
        'image',
    ),
    'image_params'      => array(
        'width'         => 300,
        'height'        => 200,
        'width_admin'   => 188,
        'height_admin'  => 100,
        'tpl'           => '<img src="{src}" alt="{title}" border="0" />',
        'tpl_admin'     => '<img src="{src}" alt="{title}" border="0" width="{width}" height="{height}" />',
    ),
    'class'             => '',
    'background'        => 'white', // examples : '#128', 'black' or 'transparent'
);
```
This is the default template, this is not where you define your blocks. Blocks are defined in the following config file **config/templates.config.php**

---

####Default Blocks
There are 3 default Blocks defined in the templates.config.php. You can either use them and personalise the css of each of them via the extension system (more informations below), or get rid of them in your bootstrap and create your own blocks.
<p>If you want to get rid of the default blocks, you'll have ton insert the following lines in your website's local/bootstrap.php (if you don't have one you can create it) :</p>

```php
Event::register_function('config|novius_blocks::templates', function(&$config) {
    unset($config['image_large']);
    unset($config['only_wysiwyg']);
    unset($config['basic']);
    return $config;
});
```

---
####Create your own blocks

To extend the config file of the available blocks, you have to create the following file :<br>
**local/config/apps/novius_blocks/templates.config.php**
<br>

Here is an example of an extended config with 2 blocks :

```php
return array(
    'my_block_1' => array(
        //Personalise your blocks here
        //title => 'My Block 1',
    ),
    'my_block_2' => array(
    ),
);
```
<p>The first level key of the array is primordial, it's the ID of your block. Here we have 'my_block_1', and 'my_block_2'.</p>
<p>All the configuration keys are optionnal, if you don't specify them, they will take the defaults vaules defined in the template_default.config.php file. Here is the list of each of the config keys</p>

- **title** : display a title above your block in the admin.
- **css** : the path of the css file for the front display (by default, it's gonna be static/apps/novius_blocks/css/front/{your_block_name.css)
- **view** : The view of your block.
- **fields** : define the fields you want to use, if you want to use all of them, you don't have to specify them.
- **image_params** : an array to define the image params ;
    - **width** : obviously the width of your image
    - **height**
    - **width_admin** : the width of the image in the admin (to reduce the dimensions)
    - **height_admin**
    - **tpl** : the template of your image, take the default config as an example
    - **tpl_admin** the template of the image in the administration
- **class** : add a class to your block wrapper
- **background** : for the administration : specify a background color for your block.

---

###CSS Files

---

For each block you have in your configurations files, you can create 3 CSS files :

>- ####The front CSS
Deals with the apparence of your block in your webpages
<br />
**url :** static/apps/novius_blocks/css/front/your_block_name.css
<br>
<br>
>- ####The back CSS
Deals with the apparence of your block in the administration (the little preview)
<br />
**url :** static/apps/novius_blocks/css/admin/your_block_name.css
<br>
<br>
>- ####The enhancer preview CSS
For the apparence of your block in the enhancer (if you activated the preview)
<br>
**url :** static/apps/novius_blocks/css/admin/your_block_name.preview.css

You don't have to specify these URLs in your config files, these are the default URLs.

---

###Views

---

####Location

><p>You have a view per block. By default, you have to create a view with this path :</p>
<p>**local/views/novius_blocks/your_block_name.view.php**</p>
<p>If you want to use a different path, you may specify it in the config key 'view' of your config file.</p>

####Available variables
>In a view file, you have several variables available. For some of them, there is 2 ways of calling them :
- **In php :** <?= $var ?> or <?php echo $var ?>
- **In a template way :** {var}

<p>Here is the list of the available variables :</p>
<br>

| Var               | Type          | Description                                                   | Available in template way {var}   |
 -------------------|---------------|---------------------------------------------------------------|-----------------------------------
| title             | string        | The title of your block                                       | yes
| name              | string        | name of the block (from your config)                          | yes
| description       | string        | Wysiwyg content                                               | yes
| link              | string        | URL of the link                                               | yes
| link_title        | string        | title of the link                                             | yes
| link_new_page     | boolean       | true if the link must open in a new window false if not &nbsp;| no
| image             | string        | html template of the block's image                            | yes
| class             | string        | class(es) of your block                                       | yes
| block             | Model Block   | The Model_Block object                                        | no



---

###Activate the preview in enhancers

It's possible to add the preview of the blocks during the implementation of an enhancer of the Blocks application.
To do this, it is necessary to extend the configuration file "controller/admin/block/enhancer.config.php" et to set the "custom" property to true in the preview array, here is an exemple of an extended configuration file :

```php
return array(
    'preview' => array(
        'custom' => true,
    ),
);
```

The application will use by default its own view, you'll just have to deal with the css collisions.
If you wish to use a custom view, you'll have to add the "view" property in the same array as the "custom" property.

To handle specific css files for the preview, you have to create the files in the same folder than the admin css : public/static/apps/css/blocks/admin

The css files have to be named like this : my_block_type.preview.css.

##Licence
Novius Blocks is licensed under [GNU Affero General Public License v3](http://www.gnu.org/licenses/agpl-3.0.html) or (at your option) any later version.
