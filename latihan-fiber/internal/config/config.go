package config

import (
	"os"

	"github.com/joho/godotenv"
)

type Konfigurasi struct {
	NamaAplikasi string
	Port         string
}

func Muat() Konfigurasi {
	godotenv.Load()
	nama := os.Getenv("APP_NAME")
	if nama == "" {
		nama = "Pemweb2 Fiber API"
	}
	port := os.Getenv("APP_PORT")
	if port == "" {
		port = "3000"
	}
	return Konfigurasi{NamaAplikasi: nama, Port: port}
}
