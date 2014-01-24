#Novius Blocks

Create and manage your blocks, include them in your content, link them with others applications of your website.

PREVIEW DANS LES ENHANCERS
## Preview in enhancers

It is possible to add the preview of the blocks during the implementation of an enhancer of the Blocks application.
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