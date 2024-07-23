<?php

class ActivityController extends AbstractController
{
    public function plage(): void
    {
        $am = new ActivityManager();
        
        $plages = $am->findAllPlages();
        
        $this -> render("",[]);
    }
}