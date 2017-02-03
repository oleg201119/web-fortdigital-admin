function ShowImagePreview( files, previewcanvas_id )
{
    if( !( window.File && window.FileReader && window.FileList && window.Blob ) )
    {
        alert('The File APIs are not fully supported in this browser.');
        return false;
    }

    if( typeof FileReader === "undefined" )
    {
        alert( "Filereader undefined!" );
        return false;
    }

    if (files.length == 0)
        return false;

    var file = files[0];

    if( !( /image/i ).test( file.type ) )
    {
        alert( "File is not an image." );
        return false;
    }

    reader = new FileReader();
    reader.onload = function(event)
    {
        var img = new Image;
        img.onload = function()
        {
            var img = this;
            var canvas = document.getElementById( previewcanvas_id );

            if( typeof canvas === "undefined"
                || typeof canvas.getContext === "undefined" )
                return;

            var context = canvas.getContext( '2d' );

            var world = new Object();
            world.width = canvas.offsetWidth;
            world.height = canvas.offsetHeight;

            canvas.width = world.width;
            canvas.height = world.height;

            if( typeof img === "undefined" )
                return;

            var WidthDif = img.width - world.width;
            var HeightDif = img.height - world.height;

            var Scale = 0.0;
            if( WidthDif > HeightDif )
            {
                Scale = world.width / img.width;
            }
            else
            {
                Scale = world.height / img.height;
            }

            if( Scale > 1 )
                Scale = 1;

            var UseWidth = Math.floor( img.width * Scale );
            var UseHeight = Math.floor( img.height * Scale );

            var x = Math.floor( ( world.width - UseWidth ) / 2 );
            var y = Math.floor( ( world.height - UseHeight ) / 2 );

            context.drawImage( img, x, y, UseWidth, UseHeight );
        }
        img.src = event.target.result;
    }
    reader.readAsDataURL( file );

    return file.name;
}

function ShowImagePreviewFromURL( image_url, previewcanvas_id )
{
    var img = new Image;
    img.onload = function()
    {
        var img = this;
        var canvas = document.getElementById( previewcanvas_id );

        if( typeof canvas === "undefined"
            || typeof canvas.getContext === "undefined" )
            return;

        var context = canvas.getContext( '2d' );

        var world = new Object();
        world.width = canvas.offsetWidth;
        world.height = canvas.offsetHeight;

        canvas.width = world.width;
        canvas.height = world.height;

        if( typeof img === "undefined" )
            return;

        var WidthDif = img.width - world.width;
        var HeightDif = img.height - world.height;

        var Scale = 0.0;
        if( WidthDif > HeightDif )
        {
            Scale = world.width / img.width;
        }
        else
        {
            Scale = world.height / img.height;
        }

        if( Scale > 1 )
            Scale = 1;

        var UseWidth = Math.floor( img.width * Scale );
        var UseHeight = Math.floor( img.height * Scale );

        var x = Math.floor( ( world.width - UseWidth ) / 2 );
        var y = Math.floor( ( world.height - UseHeight ) / 2 );

        context.drawImage( img, x, y, UseWidth, UseHeight );
    }
    img.src = image_url;
}
