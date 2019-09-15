<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190915011256 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE block_version');
        $this->addSql('ALTER TABLE block ADD event_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, ADD parent_id INT DEFAULT NULL, DROP event');
        $this->addSql('ALTER TABLE block ADD CONSTRAINT FK_831B972271F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE block ADD CONSTRAINT FK_831B9722A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE block ADD CONSTRAINT FK_831B9722727ACA70 FOREIGN KEY (parent_id) REFERENCES block (id)');
        $this->addSql('CREATE INDEX IDX_831B972271F7E88B ON block (event_id)');
        $this->addSql('CREATE INDEX IDX_831B9722A76ED395 ON block (user_id)');
        $this->addSql('CREATE INDEX IDX_831B9722727ACA70 ON block (parent_id)');
        $this->addSql('ALTER TABLE event ADD arbiter_id INT DEFAULT NULL, DROP arbiter');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7164D8144 FOREIGN KEY (arbiter_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7164D8144 ON event (arbiter_id)');
        $this->addSql('ALTER TABLE message ADD user_id INT DEFAULT NULL, ADD event_id INT DEFAULT NULL, DROP user, DROP event');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FA76ED395 ON message (user_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F71F7E88B ON message (event_id)');
        $this->addSql('ALTER TABLE vote ADD user_id INT DEFAULT NULL, ADD block_id INT DEFAULT NULL, DROP user, DROP event, DROP value, DROP block');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564E9ED820C FOREIGN KEY (block_id) REFERENCES block (id)');
        $this->addSql('CREATE INDEX IDX_5A108564A76ED395 ON vote (user_id)');
        $this->addSql('CREATE INDEX IDX_5A108564E9ED820C ON vote (block_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE block_version (id INT AUTO_INCREMENT NOT NULL, parent_block INT NOT NULL, version_block INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE block DROP FOREIGN KEY FK_831B972271F7E88B');
        $this->addSql('ALTER TABLE block DROP FOREIGN KEY FK_831B9722A76ED395');
        $this->addSql('ALTER TABLE block DROP FOREIGN KEY FK_831B9722727ACA70');
        $this->addSql('DROP INDEX IDX_831B972271F7E88B ON block');
        $this->addSql('DROP INDEX IDX_831B9722A76ED395 ON block');
        $this->addSql('DROP INDEX IDX_831B9722727ACA70 ON block');
        $this->addSql('ALTER TABLE block ADD event INT NOT NULL, DROP event_id, DROP user_id, DROP parent_id');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7164D8144');
        $this->addSql('DROP INDEX IDX_3BAE0AA7164D8144 ON event');
        $this->addSql('ALTER TABLE event ADD arbiter INT NOT NULL, DROP arbiter_id');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA76ED395');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F71F7E88B');
        $this->addSql('DROP INDEX IDX_B6BD307FA76ED395 ON message');
        $this->addSql('DROP INDEX IDX_B6BD307F71F7E88B ON message');
        $this->addSql('ALTER TABLE message ADD user INT NOT NULL, ADD event INT NOT NULL, DROP user_id, DROP event_id');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564A76ED395');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564E9ED820C');
        $this->addSql('DROP INDEX IDX_5A108564A76ED395 ON vote');
        $this->addSql('DROP INDEX IDX_5A108564E9ED820C ON vote');
        $this->addSql('ALTER TABLE vote ADD user INT NOT NULL, ADD event INT NOT NULL, ADD value INT NOT NULL, ADD block INT NOT NULL, DROP user_id, DROP block_id');
    }
}
