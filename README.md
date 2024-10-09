
# Blog API Projesi

Bu proje, Laravel kullanılarak geliştirilmiş bir Blog Yönetim Sistemi API'sidir. Proje, içerik denetimi için bir mikroservis entegrasyonu içerir ve kullanıcıların blog oluşturmasına, güncellemesine, listelemesine ve silmesine olanak tanır.

## Gereksinimler

- **PHP**: 8.x
- **Composer**: 2.x
- **MySQL**: 5.7 veya üstü
- **Node.js**: 14.x veya üstü


## Kurulum

1. **Proje deposunu klonlayın:**

   ```bash
   git clone https://github.com/fathkoc/Blogapi.git
   cd blogapi
   ```

2. **Gerekli bağımlılıkları yükleyin:**

   ```bash
   composer install
   ```


4. **Environment Dosyasını Düzenleyin:**

   `.env` dosyasındaki veritabanı ve mikroservis entegrasyonu ile ilgili alanları düzenleyin:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=veritabani_adi
   DB_USERNAME=veritabani_kullanici_adi
   DB_PASSWORD=veritabani_sifresi

   CONTENT_MODERATION_API_URL= https://portal.ayfie.com/api/sentiment
   CONTENT_MODERATION_API_KEY= TJdoLKRBwQjsurGOxeSpTMrlcACYROwslLMUUYbDRxAivsikRi

   ***key süresi dolarsa bu url den yeni key almanız gerekir
   ```


6. **Veritabanı Migrations ve Seeders Çalıştırın:**

   Veritabanı tablolarını oluşturmak ve örnek veri eklemek için:

   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. **Uygulamayı çalıştırın:**

   ```bash
   php artisan serve
   ```

   Uygulama `http://localhost:8000` adresinde çalışacaktır.

## API Uç Noktaları

### Blog Uç Noktaları

- **GET** `/blogs`: Tüm blogları listele.
- **GET** `/blogs/{id}`: Belirli bir blogun detaylarını getir.
- **POST** `/blogs`: Yeni bir blog oluştur.
  - Gerekli alanlar: `title`, `content`, `author`, `image`, `category_id`.
- **PUT** `/blogs/{id}`: Mevcut bir blogu güncelle.
  - İsteğe bağlı alanlar: `title`, `content`, `author`, `image`, `category_id`.
- **DELETE** `/blogs/{id}`: Bir blogu sil.

### Blog Oluşturma İçin Örnek İstek

```bash
curl -X POST http://localhost:8000/blogs \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Örnek Blog",
    "content": "Bu bir örnek blog içeriğidir.",
    "author": "Yazar Adı",
    "image": "http://example.com/image.jpg",
    "category_id": 1
  }'
```

### İçerik Denetimi Servisi

Bu proje, içeriklerin topluluk kurallarına uygun olduğundan emin olmak için bir içerik denetim mikroservisi ile entegre edilmiştir.

- **Environment Değişkenleri:**
  - `CONTENT_MODERATION_API_URL`: İçerik denetimi servisi URL'si.
  - `CONTENT_MODERATION_API_KEY`: Servisi kullanmak için gereken API anahtarı.


  ## Ek Bilgiler

- Veritabanının çalıştığından ve `.env` dosyasında doğru şekilde yapılandırıldığından emin olun.
- İçerik denetimi için kullanılan mikroservis API'sinin geçerli bir API anahtarı gerektirdiğini unutmayın.
- Kurulum sırasında herhangi bir sorunla karşılaşırsanız, Laravel belgelerine veya bu depoda açılan sorunlara göz atabilirsiniz.

- php artisan db:seed --class=CategorySeeder komutu ile   fake category oluşturun
- Kullandığım api metnin duygu durumuna göre score döndürmektedir negatif duygu durumundaysa ve score limiti koydum olumsuz cevap döndürmektedir.
- Api için ayrı bir translate bağlamadım onun için ingilizce metin ile deniyebilirsiniz örnek kullandığım metinleri aşşağıya ekliyorum

positive : 
"Choosing to adopt a positive mindset is one of the most empowering decisions we can make. It doesn't mean that life will always be easy or that challenges will magically disappear. Instead, it gives us the strength to face those challenges head-on, with hope in our hearts and determination in our minds. So why not start today? Embrace positivity, and watch as it transforms your life, one thought at a time."

negatife : 
"It's time to challenge the narrative that constant work is the only path to success. True fulfillment comes from finding balance—knowing when to push forward and when to take a step back. Hustle culture might promise the world, but in reality, it can take a heavy toll on our well-being, our relationships, and our overall quality of life. It’s time to reconsider what we’re really working toward, and whether the hustle is truly worth the price we pay."

### Testlerin Çalıştırılması

Unit ve feature testlerini çalıştırmak için:

```bash
php artisan test --filter=BlogApiTest
```





