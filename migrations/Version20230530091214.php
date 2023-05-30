<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230530091214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affaire ADD suivi_par_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE affaire ADD CONSTRAINT FK_9C3F18EFE440FBF8 FOREIGN KEY (suivi_par_id) REFERENCES `admin` (id)');
        $this->addSql('CREATE INDEX IDX_9C3F18EFE440FBF8 ON affaire (suivi_par_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affaire DROP FOREIGN KEY FK_9C3F18EFE440FBF8');
        $this->addSql('DROP INDEX IDX_9C3F18EFE440FBF8 ON affaire');
        $this->addSql('ALTER TABLE affaire DROP suivi_par_id');
    }
}
