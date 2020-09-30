<?php
/**
 * GalleryController
 * @package site-profile-gallery-editor
 * @version 0.0.1
 */

namespace SiteProfileGalleryEditor\Controller;

use SiteProfileGalleryEditor\Library\Meta;
use Profile\Model\Profile;
use ProfileGallery\Model\ProfileGallery as PGallery;
use LibFormatter\Library\Formatter;
use LibForm\Library\Form;

class GalleryController extends \Site\Controller
{
    public function indexAction(){
        if(!$this->profile->isLogin())
            return $this->show404();

        $params = [];

        $pname = $this->req->param->profile;
        $profile = Profile::getOne(['name'=>$pname]);
        if(!$profile || $profile->id != $this->profile->id)
            return $this->show404();

        $params = [
            'meta'    => Meta::single(),
            'profile' => $profile
        ];

        $cond = ['profile'=>$profile->id];

        $galleries = PGallery::get($cond, 0, 1, ['created'=>false]) ?? [];
        if($galleries)
            $galleries = Formatter::formatMany('profile-gallery', $galleries, ['user','profile']);
        $params['galleries'] = $galleries;

        $this->res->render('profile/gallery/editor/index', $params);
        return $this->res->send();
    }

    public function editAction(){
        if(!$this->profile->isLogin())
            return $this->show404();

        $id        = $this->req->param->id;
        $prof_name = $this->req->param->profile;
        $profile   = Profile::getOne(['name'=>$prof_name]);
        if(!$profile || $profile->id != $this->profile->id)
            return $this->show404();

        $gallery = (object)[
            'title' => '',
            'images' => '[]'
        ];

        $params = [
            'meta'    => Meta::single(),
            'profile' => $profile
        ];

        if($id){
            $gallery = PGallery::getOne(['id'=>$id,'profile'=>$profile->id]);
            if(!$gallery)
                return $this->show404();
        }

        $params['gallery'] = $gallery;

        $form = new Form('site.profile-gallery.edit');
        $params['form'] = $form;

        if(!($valid = $form->validate($gallery))|| !$form->csrfTest('csrf')){
            $this->res->render('profile/gallery/editor/edit', $params);
            return $this->res->send();
        }

        if($id){
            if(!PGallery::set((array)$valid, ['id'=>$id]))
                deb(PGallery::lastError());
        }else{
            $valid->user    = 0;
            $valid->profile = $profile->id;
            if(!PGallery::create((array)$valid))
                deb(PGallery::lastError());
        }

        $next = $this->router->to('siteProfileGalleryIndex', ['profile'=>$profile->name]);
        $this->res->redirect($next);
    }

    public function removeAction(){
        if(!$this->profile->isLogin())
            return $this->show404();

        $id        = $this->req->param->id;
        $prof_name = $this->req->param->profile;
        $profile   = Profile::getOne(['name'=>$prof_name]);
        if(!$profile || $profile->id != $this->profile->id)
            return $this->show404();

        $gallery = PGallery::getOne(['id'=>$id,'profile'=>$profile->id]);
        if(!$gallery)
            return $this->show404();

        // PGallery::remove(['id'=>$id]);

        $next   = $this->router->to('siteProfileGalleryIndex', ['profile'=>$profile->name]);

        $this->res->redirect($next);
    }
}