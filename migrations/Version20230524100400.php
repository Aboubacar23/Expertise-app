<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230524100400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE autre_controle ADD balais_masse_preconisation2 VARCHAR(255) DEFAULT NULL, ADD balais_masse_preconisation3 VARCHAR(255) DEFAULT NULL, ADD balais_masse_preconisation4 VARCHAR(255) DEFAULT NULL, ADD balais_masse_preconisation5 VARCHAR(255) DEFAULT NULL, ADD balais_masse_preconisation6 VARCHAR(255) DEFAULT NULL, DROP balais__masse_preconisation2, DROP balais__masse_preconisation3, DROP balais__masse_preconisation4, DROP balais__masse_preconisation5, DROP balais__masse_preconisation6');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE autre_controle ADD balais__masse_preconisation2 VARCHAR(255) DEFAULT NULL, ADD balais__masse_preconisation3 VARCHAR(255) DEFAULT NULL, ADD balais__masse_preconisation4 VARCHAR(255) DEFAULT NULL, ADD balais__masse_preconisation5 VARCHAR(255) DEFAULT NULL, ADD balais__masse_preconisation6 VARCHAR(255) DEFAULT NULL, DROP balais_masse_preconisation2, DROP balais_masse_preconisation3, DROP balais_masse_preconisation4, DROP balais_masse_preconisation5, DROP balais_masse_preconisation6');
    }
}
