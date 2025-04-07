# 🛠 Laravel Auth Blog API

Bu proje, Laravel 12 framework'ü ile geliştirilmiş bir **JSON tabanlı blog API sistemidir.**  
Kullanıcılar **kayıt olabilir**, **giriş yapabilir**, **JWT benzeri token** ile doğrulanır ve **blog içeriklerini CRUD** işlemleriyle yönetebilir.
**ApiResponseTrait** Sayesinde JSON yanıtları tek bir yapıdadır.
**Slug** fonksiyonu sayesinde her blog için Başlıktan üretilen benzersiz slug ile linkleriniz SEO uygun şekilde.


---

## 🚀 Özellikler

### 🔐 Kullanıcı İşlemleri (Auth)
- Kullanıcı Kaydı (`/api/register`)
- Giriş (Login) (`/api/login`)
- Çıkış (Logout) (`/api/logout`)
- Token tabanlı kimlik doğrulama (**Sanctum**)

### 📝 Blog Yazıları
- Blogları listeleme (`GET /api/posts`)
- Blog detayını gösterme (`GET /api/posts/{id|slug}`)
- Yeni blog oluşturma (`POST /api/posts`) | AUTH
- Güncelleme (`PUT /api/posts/{id}`) | AUTH
- Silme (`DELETE /api/posts/{id}`) | AUTH

### 🧠 SEO Alanları
- SEO Başlığı (`seo_title`)
- SEO Açıklaması (`seo_description`)
- SEO Anahtar Kelimeleri (`seo_keywords`)

---

## 📦 Kurulum

```bash
cd laravel-auth-blog-api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

> **Not:** API token yönetimi için `Sanctum` kullanılmıştır. Her kayıt/giriş işleminden sonra dönen token ile korunmalı endpoint’lere erişim sağlanır.

---

## 📮 API Rotaları

| Endpoint                        | Method | Açıklama                       | Auth Gerekli |
|---------------------------------|--------|--------------------------------|---------------|
| `/api/register`                | POST   | Yeni kullanıcı kaydı          | ❌ Hayır      |
| `/api/login`                   | POST   | Giriş                         | ❌ Hayır      |
| `/api/logout`                  | POST   | Çıkış                         | ✅ Evet       |
| `/api/posts`                   | GET    | Tüm postları getir           | ❌ Hayır      |
| `/api/posts/{id,slug}`         | GET    | ID veya slug ile post getir  | ❌ Hayır      |
| `/api/posts`                   | POST   | Yeni post oluştur            | ✅ Evet       |
| `/api/posts/{id}`              | PUT    | Postu güncelle               | ✅ Evet       |
| `/api/posts/{id}`              | DELETE | Postu sil                    | ✅ Evet       |

---

## 📬 Postman Collection

> Postman ile test etmek için hazır koleksiyon dosyası:  
✅ `Laravel Auth Blog Api -@MaliSahin89.postman_collection.json`

### ⚙️ Kullanım

1. Postman'i aç
2. `Import` bölümünden dosyayı yükle
3. `{{TOKEN}}` yerine giriş sonrası dönen `token`'ı ekle

---

## 📌 JSON Yanıt Formatı (Standartlaştırılmış)

Tüm başarılı yanıtlar şu şekilde döner:
```json
{
  "success": true,
  "message": "İşlem başarılı.",
  "data": { ... }
}
```

Hatalı durumlarda:
```json
{
  "success": false,
  "message": "Hata mesajı.",
  "errors": [ ... ]
}
```

Bu yapı, `ApiResponseTrait` ile merkezi olarak tanımlanmıştır.

---

## 👨‍💻 Geliştirici

> **Muhammet Ali ŞAHİN**  
> Backend PHP Laravel Developer — `https://github.com/malisahin89`
