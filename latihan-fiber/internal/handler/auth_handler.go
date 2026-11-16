package handler

import (
	"strings"
	"time"

	"latihan-fiber/internal/auth"
	"latihan-fiber/internal/config"
	"latihan-fiber/internal/model"
	"latihan-fiber/internal/validasi"

	"github.com/gofiber/fiber/v3"
	"golang.org/x/crypto/bcrypt"
)

func Registrasi(c fiber.Ctx) error {
	var permintaan PermintaanRegistrasi
	if err := c.Bind().Body(&permintaan); err != nil {
		return fiber.NewError(fiber.StatusBadRequest, "Format body tidak valid")
	}
	if galat := validasi.Periksa(permintaan); galat != nil {
		return c.Status(fiber.StatusUnprocessableEntity).JSON(fiber.Map{"sukses": false, "pesan": "Data yang dikirim tidak valid", "galat": galat})
	}
	hash, err := bcrypt.GenerateFromPassword([]byte(permintaan.KataSandi), bcrypt.DefaultCost)
	if err != nil {
		return fiber.NewError(fiber.StatusInternalServerError, "Gagal memproses kata sandi")
	}
	pengguna := model.Pengguna{Nama: permintaan.Nama, Email: permintaan.Email, KataSandi: string(hash), Peran: "mahasiswa"}
	if err := config.DB.Create(&pengguna).Error; err != nil {
		return fiber.NewError(fiber.StatusUnprocessableEntity, "Email sudah terdaftar")
	}
	return c.Status(fiber.StatusCreated).JSON(fiber.Map{"sukses": true, "pesan": "Registrasi berhasil", "data": pengguna})
}

func Login(c fiber.Ctx) error {
	var permintaan PermintaanLogin
	if err := c.Bind().Body(&permintaan); err != nil {
		return fiber.NewError(fiber.StatusBadRequest, "Format body tidak valid")
	}
	if galat := validasi.Periksa(permintaan); galat != nil {
		return c.Status(fiber.StatusUnprocessableEntity).JSON(fiber.Map{"sukses": false, "pesan": "Data yang dikirim tidak valid", "galat": galat})
	}
	var pengguna model.Pengguna
	if err := config.DB.Where("email = ?", permintaan.Email).First(&pengguna).Error; err != nil {
		return fiber.NewError(fiber.StatusUnauthorized, "Email atau kata sandi tidak sesuai")
	}
	if err := bcrypt.CompareHashAndPassword([]byte(pengguna.KataSandi), []byte(permintaan.KataSandi)); err != nil {
		return fiber.NewError(fiber.StatusUnauthorized, "Email atau kata sandi tidak sesuai")
	}
	konf := config.Muat()
	token, err := auth.TerbitkanToken(pengguna.ID, pengguna.Peran, konf.JwtSecret, konf.JwtTtlMenit)
	if err != nil {
		return fiber.NewError(fiber.StatusInternalServerError, "Gagal menerbitkan token")
	}
	return c.JSON(fiber.Map{"sukses": true, "pesan": "Login berhasil", "data": fiber.Map{"pengguna": pengguna, "token": token, "tipe": "Bearer"}})
}

func Profil(c fiber.Ctx) error {
	idPengguna := c.Locals("id_pengguna")
	var pengguna model.Pengguna
	if err := config.DB.First(&pengguna, idPengguna).Error; err != nil {
		return fiber.NewError(fiber.StatusNotFound, "Pengguna tidak ditemukan")
	}
	return c.JSON(fiber.Map{"sukses": true, "data": pengguna})
}

func Segarkan(c fiber.Ctx) error {
	idPengguna, _ := c.Locals("id_pengguna").(uint)
	peran, _ := c.Locals("peran").(string)
	if idPengguna == 0 || peran == "" {
		return fiber.NewError(fiber.StatusUnauthorized, "Token tidak valid atau sudah kedaluwarsa")
	}
	konf := config.Muat()
	token, err := auth.TerbitkanToken(idPengguna, peran, konf.JwtSecret, konf.JwtTtlMenit)
	if err != nil {
		return fiber.NewError(fiber.StatusInternalServerError, "Gagal menerbitkan token")
	}
	return c.JSON(fiber.Map{"sukses": true, "pesan": "Token berhasil diperbarui", "data": fiber.Map{"token": token, "tipe": "Bearer"}})
}

func Logout(c fiber.Ctx) error {
	bagian := strings.Split(c.Get("Authorization"), " ")
	if len(bagian) != 2 || bagian[0] != "Bearer" {
		return fiber.NewError(fiber.StatusBadRequest, "Format header Authorization tidak sesuai")
	}
	klaim, err := auth.PeriksaToken(bagian[1], config.Muat().JwtSecret)
	if err != nil {
		return fiber.NewError(fiber.StatusUnauthorized, "Token tidak valid atau sudah kedaluwarsa")
	}
	config.DB.Where("kedaluwarsa < ?", time.Now()).Delete(&model.TokenHitam{})
	catatan := model.TokenHitam{Token: bagian[1], Kedaluwarsa: klaim.ExpiresAt.Time}
	if err := config.DB.Create(&catatan).Error; err != nil {
		return fiber.NewError(fiber.StatusUnprocessableEntity, "Gagal mencabut token")
	}
	return c.JSON(fiber.Map{"sukses": true, "pesan": "Logout berhasil, token telah dicabut"})
}
