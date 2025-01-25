<?php

namespace App\Services\Admin\MarketingTool;

use App\Repositories\Admin\MarketingTool\MarketingToolRepositoryInterface;

class MarketingToolService
{
    protected $marketingToolRepository;

    public function __construct(MarketingToolRepositoryInterface $marketingToolRepository)
    {
        $this->marketingToolRepository = $marketingToolRepository;
    }

    public function all()
    {
        $tools = $this->marketingToolRepository->all();
        $scripts = [];


        foreach ($tools as $tool) {
            $scripts[] = $this->generateScript($tool);
        }


        return response()->json($scripts);
    }

    private function generateScript($tool)
    {
        // Check the name of the tool and generate the appropriate script
        switch ($tool->name) {
            case 'Facebook Pixel':
                return $this->generateFacebookPixelScript($tool);

            case 'Google Analytics':
                return $this->generateGoogleAnalyticsScript($tool);

            case 'Google Tag Manager':
                return $this->generateGoogleTagManagerScript($tool);

            case 'Domain Verification':
                return $this->generateDomainVerificationScript($tool);

            default:
                return $this->generateDefaultScript($tool);
        }
    }


    private function generateFacebookPixelScript($tool)
    {
        if ($tool->identifier) {
            return "<script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];
            t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{$tool->identifier}');
            fbq('track', 'PageView');
        </script>";
        }

        return '';
    }

    private function generateGoogleAnalyticsScript($tool)
    {
        if ($tool->identifier) {
            return "<script async src='https://www.googletagmanager.com/gtag/js?id={$tool->identifier}'></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{$tool->identifier}');
        </script>";
        }

        return '';
    }

    private function generateGoogleTagManagerScript($tool)
    {
        if ($tool->identifier) {
            return "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{$tool->identifier}');</script>";
        }

        return '';
    }

    private function generateDomainVerificationScript($tool)
    {
        
        if ($tool->script) {
            return $tool->script;
        }

        return ''; 
    }

    private function generateDefaultScript($tool)
    {
       
        return '';
    }


    public function create(array $data)
    {
        return $this->marketingToolRepository->create($data);
    }

    public function find($id)
    {
        return $this->marketingToolRepository->find($id);
    }

    public function update(array $data, $id)
    {
        return $this->marketingToolRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->marketingToolRepository->delete($id);
    }

    public function getLatest()
    {
        return $this->marketingToolRepository->getLatest();
    }
}
