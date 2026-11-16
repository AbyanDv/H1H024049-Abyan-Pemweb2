package model

import "time"

type Matakuliah struct {
	ID        uint      `gorm:"primaryKey" json:"id"`
	Kode      string    `gorm:"size:10;uniqueIndex" json:"kode"`
	Nama      string    `gorm:"size:100" json:"nama"`
	Sks       int       `gorm:"type:tinyint unsigned" json:"sks"`
	Semester  int       `gorm:"type:tinyint unsigned" json:"semester"`
	CreatedAt time.Time `json:"dibuat_pada"`
	UpdatedAt time.Time `json:"diubah_pada"`
}
