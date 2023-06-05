<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230605074147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hydro_aero (id INT AUTO_INCREMENT NOT NULL, conformite1 VARCHAR(255) DEFAULT NULL, conformite2 VARCHAR(255) DEFAULT NULL, conformite3 VARCHAR(255) DEFAULT NULL, conformite4 VARCHAR(255) DEFAULT NULL, conformite5 VARCHAR(255) DEFAULT NULL, preconisation1 VARCHAR(255) DEFAULT NULL, preconisation2 VARCHAR(255) DEFAULT NULL, preconisation3 VARCHAR(255) DEFAULT NULL, preconisation4 VARCHAR(255) DEFAULT NULL, preconisation5 VARCHAR(255) DEFAULT NULL, retenu1 VARCHAR(255) DEFAULT NULL, retenu2 VARCHAR(255) DEFAULT NULL, retenu3 VARCHAR(255) DEFAULT NULL, retenu4 VARCHAR(255) DEFAULT NULL, retenu5 VARCHAR(255) DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parametre ADD hydro_aero_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC79041F3A57AB4 FOREIGN KEY (hydro_aero_id) REFERENCES hydro_aero (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACC79041F3A57AB4 ON parametre (hydro_aero_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC79041F3A57AB4');
        $this->addSql('DROP TABLE hydro_aero');
        $this->addSql('DROP INDEX UNIQ_ACC79041F3A57AB4 ON parametre');
        $this->addSql('ALTER TABLE parametre DROP hydro_aero_id');
    }
}
