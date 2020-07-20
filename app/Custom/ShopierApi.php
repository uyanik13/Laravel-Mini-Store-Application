<?php
namespace App\Custom;

use Shopier\Enums\ProductType;
use Shopier\Enums\WebsiteIndex;
use Shopier\Exceptions\NotRendererClassException;
use Shopier\Exceptions\RendererClassNotFoundException;
use Shopier\Exceptions\RequiredParameterException;
use Shopier\Models\Address;
use Shopier\Models\Buyer;
use Shopier\Renderers\AutoSubmitFormRenderer;
use Shopier\Renderers\ButtonRenderer;
use Shopier\Shopier;


    class ShopierApi
    {
        public function __construct()
        {
            $this->api_key = env('SHOPIER_API_KEY', '');
            $this->api_secret = env('SHOPIER_API_SECRET','');
        }

        public function create_payment($userData)
        {
            $api_key    = $this->api_key ;
            $api_secret =  $this->api_secret;

            $shopier = new Shopier($api_key, $api_secret);

            $buyer = new Buyer([
                'id' => $userData['id'],
                'name' => $userData['first_name'],
                'surname' => $userData['last_name'],
                'email' => $userData['email'],
                'phone' => $userData['phone'],
            ]);

            // Fatura ve kargo adresi birlikte tanımlama
            // Ayrı ayrı da tanımlanabilir
            $address = new Address([
                'address' => $userData['address'],
                'city' => $userData['city'],
                'country' => $userData['country'],
                'postcode' => $userData['post_code'],
            ]);

            // shopier parametrelerini al
            $params = $shopier->getParams();

            // Geri dönüş sitesini ayarla
            $params->setWebsiteIndex(WebsiteIndex::SITE_1);

            // Satın alan kişi bilgisini ekle
            $params->setBuyer($buyer);

            // Fatura ve kargo adresini aynı şekilde ekle
            $params->setAddress($address);

            // Sipariş numarası ve sipariş tutarını ekle
            $params->setOrderData($userData['order_id'], $userData['amount']);

            // Sipariş edilen ürünü ekle
            $params->setProductData('Mini İşletmem Servis Ücreti', ProductType::DOWNLOADABLE_VIRTUAL);

            try {

                /**
                 * Otomatik ödeme sayfasına yönlendiren renderer
                 *
                 * @var AutoSubmitFormRenderer $renderer
                 */
                   $renderer = $shopier->createRenderer(AutoSubmitFormRenderer::class);
                   $shopier->goWith($renderer);


                /**
                 * Shopier İle Güvenli Öde şeklinde butona tıklanınca ödeme sayfasına yönlendiren renderer
                 *
                 * @var ButtonRenderer $renderer
                 */
                $renderer = $shopier->createRenderer(ButtonRenderer::class);
                $renderer
                    ->withStyle("padding:15px; color: #fff; background-color:#7367F0; border:1px solid #fff; border-radius:7px")
                    ->withText('Shopier Güvenli Ödeme Ekranı');

                $shopier->goWith($renderer);

            } catch (RequiredParameterException $e) {
                // Zorunlu parametrelerden bir ve daha fazlası eksik
            } catch (NotRendererClassException $e) {
                // $shopier->createRenderer(...) metodunda verilen class adı AbstractRenderer sınıfından türetilmemiş !
            } catch (RendererClassNotFoundException $e) {
                // $shopier->createRenderer(...) metodunda verilen class bulunamadı !
            }
        }


    }

