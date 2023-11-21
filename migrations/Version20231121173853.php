<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231121173853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FA76ED395');
        $this->addSql('DROP INDEX UNIQ_8157AA0FA76ED395 ON profile');
        $this->addSql('ALTER TABLE profile DROP user_id');
        $this->addSql('ALTER TABLE tp4_bd ADD profile_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tp4_bd ADD CONSTRAINT FK_DD1EA4A4CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DD1EA4A4CCFA12B8 ON tp4_bd (profile_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tp4_bd DROP FOREIGN KEY FK_DD1EA4A4CCFA12B8');
        $this->addSql('DROP INDEX UNIQ_DD1EA4A4CCFA12B8 ON tp4_bd');
        $this->addSql('ALTER TABLE tp4_bd DROP profile_id');
        $this->addSql('ALTER TABLE profile ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FA76ED395 FOREIGN KEY (user_id) REFERENCES tp4_bd (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8157AA0FA76ED395 ON profile (user_id)');
    }
}
