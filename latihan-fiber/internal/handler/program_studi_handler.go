package handler

import (
	"latihan-fiber/internal/repository"

	"github.com/gofiber/fiber/v3"
)

func DaftarProgramStudi(c fiber.Ctx) error {
	daftar, err := repository.AmbilProgramStudi()
	if err != nil {
		return fiber.NewError(fiber.StatusInternalServerError, "Gagal mengambil data")
	}

	return c.JSON(fiber.Map{
		"sukses": true,
		"data":   daftar,
	})
}
