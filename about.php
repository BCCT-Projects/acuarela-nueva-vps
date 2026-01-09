<?php include 'includes/header.php'; 
?>
    <main class="container">
        <!-- BANNER -->
        <section class="banner">
            <div class="banner__texts">
                <h1 class="banner__title">
                <?=$a->about->acf->banner->titulo?>
                </h1>
                <h3 class="banner__subtitle banner__subtitle--little">
                    <?=$a->about->acf->banner->descripcion?>
                </h3>
            </div>
            <img
                class="banner__img banner__img--no-border"
                src="<?=$a->about->acf->banner->imagen?>"
            />
        </section>

        <!-- ADD-ONS -->

        <section class="add-on add-on--left add-on--end">
            <img class="add-on__img" src="<?=$a->about->acf->seccion_1->imagen?>" />
            <div class="add-on__texts">
                <h3 class="add-on__title"><?=$a->about->acf->seccion_1->titulo?></h3>
                <p class="add-on__description">
                   <?=$a->about->acf->seccion_1->descripcion?>
                </p>
                <button class="btn btn--primary"   onclick="window.location.href='/invitaciones'">
                    <span class="btn__text"><?=$a->about->acf->seccion_1->texto_boton?> </span>
                </button>
            </div>
        </section>

        <section class="add-on">
            <div class="add-on__texts">
                <h3 class="add-on__title">
                <?=$a->about->acf->seccion_2->titulo?>
                </h3>
                <p class="add-on__description">
                <?=$a->about->acf->seccion_2->descripcion?>
                </p>
            </div>
            <img class="add-on__img" src="<?=$a->about->acf->seccion_2->imagen?>" />
        </section>

        <section class="testimonials">
            <h1>Testimonios</h1>

            <div class="testimonials-cont">
                <?php 
                $testimonios = $a->getTestimonios();
                for ($i=0; $i < count($testimonios); $i++) { 
                    $testimonio = $testimonios[$i];
                ?>
                <div class="testimonials-cont__testimonial">
                    <img
                        class="testimonials-cont__avatar"
                        src="  <?=$testimonio->acf->imagen?> "
                    />
                    <div class="testimonials-cont__texts">
                        <div class="testimonials-cont__top">
                            <div>
                                <p class="testimonials-cont__name">
                                    <?=$testimonio->title->rendered?> 
                                </p>
                                <p class="testimonials-cont__role">  <?=$testimonio->acf->cargo?> </p>
                            </div>
                            <p class="testimonials-cont__date"></p>
                        </div>
                        <p class="testimonials-cont__message">
                        <?=$testimonio->content->rendered?> 
                        </p>
                    </div>
                </div>
                <? } ?>
            </div>
        </section>
    </main>
<?php include 'includes/footer.php'; ?>