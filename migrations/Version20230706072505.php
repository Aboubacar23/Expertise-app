<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230706072505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lplaque (id INT AUTO_INCREMENT NOT NULL, service VARCHAR(255) DEFAULT NULL, classe_isolation VARCHAR(255) DEFAULT NULL, indice_protection VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parametre ADD lplaque_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC7904116C31730 FOREIGN KEY (lplaque_id) REFERENCES lplaque (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACC7904116C31730 ON parametre (lplaque_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC7904116C31730');
        $this->addSql('DROP TABLE lplaque');
        $this->addSql('DROP INDEX UNIQ_ACC7904116C31730 ON parametre');
        $this->addSql('ALTER TABLE parametre DROP lplaque_id');
    }
}
