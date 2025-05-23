<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250512062424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE opportunity (id INT GENERATED BY DEFAULT AS IDENTITY NOT NULL, job_title VARCHAR(255) NOT NULL, company VARCHAR(255) NOT NULL, contract_type VARCHAR(100) NOT NULL, location VARCHAR(255) NOT NULL, salary_min DOUBLE PRECISION DEFAULT NULL, salary_max DOUBLE PRECISION DEFAULT NULL, salary_currency VARCHAR(10) DEFAULT NULL, status VARCHAR(50) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, recruiter_id INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8389C3D7156BE243 ON opportunity (recruiter_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE recruiter (id INT GENERATED BY DEFAULT AS IDENTITY NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, company VARCHAR(255) NOT NULL, linkedin_profile VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(50) DEFAULT NULL, status VARCHAR(50) NOT NULL, notes TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D7156BE243 FOREIGN KEY (recruiter_id) REFERENCES recruiter (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE opportunity DROP CONSTRAINT FK_8389C3D7156BE243
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE opportunity
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE recruiter
        SQL);
    }
}
