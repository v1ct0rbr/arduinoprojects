<!-- Start Nav Backed Header -->
<div class="nav-backed-header parallax wow pulse" style="background-image:url({$_IMG_SITE}/IMG_0025_02.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{$_URLSITE}">Home</a></li>
                        {if $sub_page}
                        <li><a href="{$_URLSITE}/{$page}">{$page}</a></li> <li class="active">{$sub_page}</li>
                        {else}
                        <li class="active">{$page}</li>
                        {/if}
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- End Nav Backed Header --> 
<!-- Start Page Header -->
<div class="page-header wow bounceInRight">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{$title_page}</h1>
            </div>
        </div>
    </div>
</div>
<!-- End Page Header --> 