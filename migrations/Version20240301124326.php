<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240301124326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add employees table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
        CREATE TABLE IF NOT EXISTS employees (
                id INT AUTO_INCREMENT PRIMARY KEY,
                first_name VARCHAR(50) NOT NULL,
                last_name VARCHAR(50) NOT NULL,
                email VARCHAR(255) NOT NULL,
                phone_number VARCHAR(20) DEFAULT NULL,
                company_id INT UNSIGNED,
                FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE
            )
        ');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS employees');
    }
}
