package router

import (
	"latihan-fiber/internal/handler"

	"github.com/gofiber/fiber/v3"
)

func Daftarkan(app *fiber.App) {
	api := app.Group("/api")
	api.Get("/status", func(c fiber.Ctx) error {
		return c.JSON(fiber.Map{
			"sukses": true,
			"pesan":  "API Fiber aktif",
		})
	})
	mahasiswa := api.Group("/mahasiswa")
	mahasiswa.Get("/", handler.DaftarMahasiswa)
	mahasiswa.Get("/:id", handler.DetailMahasiswa)
}
