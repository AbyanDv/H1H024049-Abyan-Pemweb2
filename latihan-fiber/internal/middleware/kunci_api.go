package middleware

import (
	"crypto/subtle"

	"github.com/gofiber/fiber/v3"
)

func KunciApi(kunci string) fiber.Handler {
	return func(c fiber.Ctx) error {
		dikirim := c.Get("X-Api-Key")
		if kunci == "" || subtle.ConstantTimeCompare([]byte(dikirim), []byte(kunci)) != 1 {
			return c.Status(fiber.StatusUnauthorized).JSON(fiber.Map{
				"sukses": false,
				"pesan":  "Kunci API tidak valid",
			})
		}

		return c.Next()
	}
}
